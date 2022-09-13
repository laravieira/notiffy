<?PHP

namespace UFJFNews\Extractors;

use DateTime;
use Notiffy\Notiffy;
use Notiffy\NotiffyException;
use UFJFNews\Objects\Category;
use UFJFNews\Objects\Post;
use UFJFNews\Objects\StyleExtract;
use UFJFNews\UFJFNews;

use function Scraping\strpart;
use function Scraping\strmpart;

class NewStyleExtract extends StyleExtract
{
    
    public function savePosts()
    {
        $this->new = array();
        
        if(Notiffy::TEST_MODE) {
            $this->testMode();
            return;
        }

        foreach($this->posts as $post) {
            if(!$post->new)
                continue;

            $query = 'INSERT INTO '.UFJFNews::DATABASE_TABLE.' (id, title, design, `group`, catname, link, date)'
                    .'VALUES (:id, :title, :design, :group, :catname, :link, :date);';
            $date  = date_format($post->date, 'Y-m-d');

            $stmt = Notiffy::getDB()->prepare($query);
            $stmt->bindParam(':id',      $post->id);
            $stmt->bindParam(':title',   $post->title);
            $stmt->bindParam(':design',  $post->design);
            $stmt->bindParam(':group',   $post->group);
            $stmt->bindParam(':catname', $post->category->name);
            $stmt->bindParam(':link',    $post->link);
            $stmt->bindParam(':date',    $date);
            $stmt->execute();

            Notiffy::log("News $post->id saved in knowledge base.");
            $this->new[] = $post->id;
        }
    }

    private function buildId(array $posts, string $date): string
    {
        $count = 1;
        foreach($posts as $key => $post) {
            if(str_starts_with($key, $date))
                $count++;
        }
        return $date.$count;
    }

    function hasDupes(array $links, string $link): bool
    {
        foreach($links as $url)
            if($url === $link)
                return true;
        return false;
    }

    /** @throws NotiffyException */
    function extract(int $startPage=1, int $endPage=2)
    {
        if(!strpos(parent::server(), 'sitemap'))
            return $this->posts = $this->extractPosts($startPage, $endPage);
        
        Notiffy::log('Getting links to search based on sitemap.');
    
        $links = explode('href', strpart(parent::get('')['content'], 'href'));
        if(empty($links)) return null;

        $this->posts = array();
        $server = parent::server();
        foreach($links as &$link) {
            $url = strpart($link, '"', '"');
            
            if(!strpos($url, '/category') || $this->hasDupes($links, $url))
                continue;

            parent::server($link = $url);
            $this->posts += $this->extractPosts(1, 1);
        }

        parent::server($server);
        return $this->posts;
    }

    /** @throws NotiffyException */
    private function extractPosts(int $startPage=1, int $endPage=2): array
    {
        $posts = array();
        do {
            $response = parent::get($startPage>1?"page/$startPage/":'');
            $response = strpart($response['content'], '>Todos os Avisos</h2>', '<div class="row wp_custom_row">');
            $response = explode('<div class="row todas-noticias">', strpart($response, '<div class="row todas-noticias">'));
            
            Notiffy::log('Extrating data from each news.');
        
            // This array reverse is necessary to build the correct ids.
            $response = array_reverse($response);
            foreach($response as $data) {
                $lk = strpart($data, 'href="', '"');
                $dt = explode('/', $lk);

                $post = new Post(
                    $this->identifier.$this->buildId($posts, $dt[4].$dt[5].$dt[6]),
                    trim(strmpart($data, '<a', '>', '</a>')),
                    'N',
                    $this->identifier,
                    $lk,
                    new DateTime("$dt[4]/$dt[5]/$dt[6]") // Y-m-d
                );

                $post->category = new Category(
                    trim(strmpart($data, '<h6', '>', '</h6>' ))
                );

                if(strlen($post->id) < 2 || !isset($post) || !$post->date
                || empty($post->title)
                || empty($post->category->name)
                || empty($post->link)
                )
                    throw new NotiffyException('Can\'t get a post data');
                $posts[$post->id] = $post;
            }
        }while($startPage++ < $endPage);
        return $posts;
    }

}