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

class MainStyleExtract extends StyleExtract
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

            $query = 'INSERT INTO '.UFJFNews::DATABASE_TABLE.' (id, title, design, `group`, catname, catlink, catcolor, link, tumbnail, date)'
                    .'VALUES (:id, :title, :design, :group, :catname, :catlink, :catcolor, :link, :tumbnail, :date);';
            $date  = date_format($post->date, 'Y-m-d');

            $stmt = Notiffy::getDB()->prepare($query);
            $stmt->bindParam(':id',       $post->id);
            $stmt->bindParam(':title',    $post->title);
            $stmt->bindParam(':design',   $post->design);
            $stmt->bindParam(':group',    $post->group);
            $stmt->bindParam(':catname',  $post->category->name);
            $stmt->bindParam(':catlink',  $post->category->link);
            $stmt->bindParam(':catcolor', $post->category->color);
            $stmt->bindParam(':link',     $post->link);
            $stmt->bindParam(':tumbnail', $post->tumbnail);
            $stmt->bindParam(':date',     $date);
            $stmt->execute();

            Notiffy::log("News {$post->id} saved in knowledge base.");
            $this->new[] = $post->id;
        }
    }

    public function parseDate($s)
    {
        $s = explode(" ", $s);
        switch($s[2]) {
            case "janeiro":   $s[1] = 1;  break;
            case "fevereiro": $s[1] = 2;  break;
            case "março":     $s[1] = 3;  break;
            case "abril":     $s[1] = 4;  break;
            case "maio":      $s[1] = 5;  break;
            case "junho":     $s[1] = 6;  break;
            case "julho":     $s[1] = 7;  break;
            case "agosto":    $s[1] = 8;  break;
            case "setembro":  $s[1] = 9;  break;
            case "outubro":   $s[1] = 10; break;
            case "novembro":  $s[1] = 11; break;
            case "dezembro":  $s[1] = 12; break;
            default: return false;
        }
        return new DateTime("{$s[4]}-{$s[1]}-{$s[0]}"); // Y-m-d
    }

    /** @throws NotiffyException */
    public function extract(int $startPage=1, int $endPage=2)
    {
        $posts = array();
        do {
            $response = parent::get($startPage>1?"page/".$startPage.'/':'');
            $response = strpart($response['content'], '<div id="main" class="main-post">', '<div id="pagination"');
            $response = explode('<article', strpart($response, '<article'));
        
            Notiffy::log('Extrating data from each news.');
        
            foreach($response as $data) {
                $tumbnail = strmpart($data, '<img', 'src="', '"');
                $post = new Post(
                    $this->identifier.strmpart($data, 'id="', '-', '"'),
                    trim(strpart($data, '<h2>', '</h2>')),
                    'M',
                    $this->identifier,
                    strmpart($data, 'post-image">', 'href="', '"'),
                    $this->parseDate(trim(strmpart($data, 'post-date"', '>', "</div"))),
                    empty($tumbnail)?null:$tumbnail
                );
                $post->category = new Category(
                    trim(strmpart($data, 'rel="category', '>', '</a>')),
                    strmpart($data, '<div class="categoria', 'href="', '"')
                );
                
                if(strlen($post->id) < 2 || !isset($post) || !$post->date
                || empty($post->title)
                || empty($post->category->name)
                || empty($post->category->link)
                || empty($post->link)
                )
                    throw new NotiffyException('Can\'t get a post data');
                $posts[$post->id] = $post;
            }
        }while($startPage++ < $endPage);
        return empty($posts)?null:($this->posts = $posts);
    }
}