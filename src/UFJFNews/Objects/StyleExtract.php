<?PHP

namespace UFJFNews\Objects;

use Notiffy\Notiffy;
use Notiffy\NotiffyException;
use Scraping\Scraping;
use UFJFNews\UFJFNews;

class StyleExtract extends Scraping
{
    protected string  $letter;
    protected array   $posts;
    public    array   $new;
    protected string  $sqlsave;
    protected string  $identifier;

    
    public function __construct(string $page_link, string $identifier)
    {
        $this->identifier = $identifier;
        $this->new = array();
        parent::__construct($page_link, UFJFNews::NAME);
    }
    
    public function posts(): array
    {
        return $this->posts;
    }

    public function newIds(): array
    {
        return $this->new;
    }

    public function hasNew(): bool
    {
        return !empty($this->new);
    }

    public function testMode(): void
    {
        $i = 0;
        foreach($this->posts as $post) {
            if(rand(0, 10) || ++$i > 5)
                continue;
            
            $post->new = true;
            $this->new[] = $post->id;
            Notiffy::log("[TESTMODE] News $post->id listed as new.");
        }
    }

    private function parseIds(): string
    {
        $ids = '';
        foreach($this->posts as $post)
            $ids .= ", '$post->id'";
            
        if(strlen($ids) > 2)
            $ids = substr($ids, 2);
        return $ids;
    }

    public function sortByDate(): void
    {
        $sort = array(); // sort DESC
        while(!empty($this->posts)) {
            $newer = $this->posts[array_key_first($this->posts)];
            foreach($this->posts as $post)
                if($post->date > $newer->date)
                    $newer = $post;
            $sort[$newer->id] = $newer;
            unset($this->posts[$newer->id]);
        }
        $this->posts = $sort;
    }

    /** @throws NotiffyException */
    public function validate(): void
    {
        Notiffy::log('Validating posts in knowledge base.');

        $ids = $this->parseIds();
        
        $stmt = Notiffy::getDB()->Query("SELECT id FROM ".UFJFNews::DATABASE_TABLE." WHERE id IN($ids);");

        if($stmt == false || $stmt->rowCount() < 0)
            throw new NotiffyException('Unable to validate in knowledge base.');

        foreach($stmt->fetchAll() as $line)
            $this->posts[$line['id']]->new = false;
            
        Notiffy::log('Validation completed.');
    }

    /** @throws NotiffyException */
    private function check(array $data, bool $headers): array
    {
        if(($headers && !$data['request']) || ($headers && !$data['header']) || !$data['content'] || !$data['url'] || !$data['code'])
            throw new NotiffyException('Unable to colect page data.');
        else if($data['code'] == 401)
            throw new NotiffyException('Permission required.');
        else if($data['code'] != 200 && $data['code'] != 302 && $data['code'] != 303)
            throw new NotiffyException('Unable to access the page.');
        else return $data;
    }

    /** @throws NotiffyException */
    public function get(string $link, bool $headers=false): array
    {
        Notiffy::log('Getting request to '.parent::server().$link);
        return self::check(parent::get($link, $headers), $headers);
    }

    /** @throws NotiffyException */
    public function post(string $link, array $post, array $header=null, bool $headers=false): array
    {
        Notiffy::log('Posting request to '.parent::server().$link);
        return self::check(parent::post($link, $post, $header, $headers), $headers);
    }
}