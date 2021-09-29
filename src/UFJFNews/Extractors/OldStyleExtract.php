<?PHP

namespace UFJFNews\Extractors;

use DateTime;
use Notiffy\Notiffy;
use Notiffy\NotiffyException;
use UFJFNews\Objects\Post;
use UFJFNews\Objects\StyleExtract;
use UFJFNews\UFJFNews;

use function Scraping\strpart;
use function Scraping\strmpart;

class OldStyleExtract extends StyleExtract
{

    public function savePosts(): void
    {
        $this->new = array();

        if (Notiffy::TEST_MODE) {
            $this->testMode();
            return;
        }

        foreach($this->posts as $post) {
            if(!$post->new)
                continue;

            $query = 'INSERT INTO '.UFJFNews::DATABASE_TABLE.' (id, title, design, `group`, link, date)'
                    .'VALUES (:id, :title, :design, :group, :link, :date);';
            $date  = date_format($post->date, 'Y-m-d');

            $stmt = Notiffy::getDB()->prepare($query);
            $stmt->bindParam(':id',     $post->id);
            $stmt->bindParam(':title',  $post->title);
            $stmt->bindParam(':design', $post->design);
            $stmt->bindParam(':group',  $post->group);
            $stmt->bindParam(':link',   $post->link);
            $stmt->bindParam(':date',   $date);
            $stmt->execute();

            Notiffy::log("News $post->id saved in knowledge base.");
            $this->new[] = $post->id;
        }
    }

    /** @throws NotiffyException */
    public function extract(int $startPage=1, int $endPage=2): ?array
    {
        $posts = array();

        $response = parent::get('');
        if(!isset($response)) return null;
    
        $response = strpart($response["content"], '<div id="conteudo">', '<div id="banners">');
        $response = explode('<p', strpart($response, '<p'));
        if(empty($response)) return null;
    
        Notiffy::log('Extrating data from each news.');
    
        foreach($response as $data) {
            $lk = strpart($data, 'href="', '"');
            $dt = explode("/", $lk);

            $post = new Post(
                id:     $this->identifier.strmpart($data, 'id="', '-', '"'),
                title:  trim(strmpart($data, '<a', '>', '</a>')),
                design: 'O',
                group:  $this->identifier,
                link:   $lk,
                date:   new DateTime("$dt[4]-$dt[5]-$dt[6]"), // Y-m-d
            );

            if(strlen($post->id) < 2 || !isset($post) || !$post->date
            || empty($post->title)
            || empty($post->link)
            )
                throw new NotiffyException('Can\'t get a post data');
            $posts[$post->id] = $post;
        }
        return empty($posts)?null:($this->posts = $posts);
    }
}