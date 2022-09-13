<?PHP 

namespace UFJFCalendar;

use DateTime;
use Exception;
use Notiffy\Notiffy;
use Notiffy\NotiffyException;
use Scraping\Scraping;
use UFJFCalendar\Objects\Calendar;
use UFJFCalendar\Objects\Link;

use function Scraping\strpart;

class CalendarExtract extends Scraping
{
    public $calendars = array();
    public $links = array();
    public   $show = 9;
    public $new  = array();

    public function __construct()
    {
        parent::__construct('', UFJFCalendar::NAME);
    }

    public function addLink(string $link)
    {
        $this->links[] = new Link($link, '', '');
    }

    public function hasNew(): bool
    {
        return !empty($this->new);
    }

    public function testMode()
    {
        $i = 0;
        foreach($this->calendars as $calendar) {
            if(rand(0, 10) || ++$i > 5)
                continue;
            
            $calendar->new = true;
            $this->new[] = $calendar->link;
            Notiffy::log("[TESTMODE] Calendar {$calendar->title} listed as new.");
        }
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
    
    public function sortByDate()
    {
        $sorted = array(); // sort DESC
        while(!empty($this->calendars)) {
            $newer = $this->calendars[array_key_first($this->calendars)];
            foreach($this->calendars as $calendar)
                if($calendar->date > $newer->date)
                    $newer = $calendar;
            $sorted[$newer->link] = $newer;
            unset($this->calendars[$newer->link]);
        }
        $this->calendars = $sorted;
    }

    private function buildDate(string $url): DateTime
    {
        if(strpos($url, 'sites/'))
            $dt = explode('/', strpart($url, 'sites/'), 4);
        elseif(strpos($url, '/files'))
            $dt = explode('/', strpart($url, '/files'), 4);
        else
            return new DateTime('now');
        return DateTime::createFromFormat('Y-m-d', "$dt[1]-$dt[2]-".date('d'));
    }

    function hasDupes(array $links, string $link): bool
    {
        foreach($links as $url)
            if($url->url === $link)
                return true;
        return false;
    }

    private function parseTagA(array $tags): array
    {
        $links = array();
        foreach($tags as $tag) {
            $links[] = new Link(
                strpart($tag, 'href="', '"'),
                trim(strip_tags('<a'.$tag))
            );
        }
        return $links;
    }

    private function parseTagP(array $tags): array
    {
        $links = array();
        foreach($tags as $tag) {
            if(strpos(strpart($tag, 'href="'), 'href="'))
                continue;
            $links[] = new Link(
                strpart($tag, 'href="', '"'),
                trim(strip_tags('<p'.$tag))
            );
        }
        return $links;
    }

    /** @throws NotiffyException */
    private function links(string $body)
    {
        $body = strpart($body, 'class="content"', '</div>');
        $links = strip_tags($body, ['<a>', '<p>']);

        $linksA = $this->parseTagA(explode('<a', $links));
        $linksP = $this->parseTagP(explode('<p', $links));

        $this->links = array_merge($this->links, $linksP, $linksA);
        
        if(empty($this->links))
            throw new NotiffyException('Unable to gets links.');
    }
    
    private function filter(string $filter)
    {
        $filtered = [];
        foreach($this->links as $link) {
            if(strpos($link->url, $filter))
                $filtered[] = $link;
        }
        $this->links = $filtered;
    }
    
    private function clear()
    {
        // Clear main links, social links and repeted links.
        $links = array();
        foreach($this->links as $link) {
            if(empty($link->url))
                continue;
            if(!str_contains($link->url, 'http'))
                continue;
            if(strpos($link->url, '.pdf'))
                continue;
            if(strpos($link->url, '.doc'))
                continue;
            if(strpos($link->url, '.docx'))
                continue;
            if(strpos($link->url, '?'))
                continue;
            
            $already = false;
            foreach($links as $unique) {
                if(strstr($link->url, "://") === strstr($unique->url, "://")) {
                    if($link->url !== $unique->url)
                        $unique->url = "https".strstr($unique->url, "://");
                    $already = true;
                    break;
                }
            }
            if(!$already)
                $links[] = $link;
        }
        $this->links = $links;
    }
    
    private function build()
    {
        foreach($this->links as $link) {
            if(!strpos($link->url, '.pdf')
            && !strpos($link->url, '.doc')
            && !strpos($link->url, '.docx')
            )
                continue;

            $already = false;
            foreach($this->calendars as $calendar)
                if(strstr($link->url, '://') == strstr($calendar->link, '://')) {
                    if($link->url != $calendar->link)
                        $calendar->link = 'https'.strstr($calendar->link, '://');
                    $already = true;
                }
            if(!$already) {
                $url   = html_entity_decode($link->url, ENT_QUOTES, 'UTF-8');
                $text  = html_entity_decode(str_replace('&nbsp;', ' ', $link->text), ENT_QUOTES, 'UTF-8');
                $date  = $this->buildDate($url);
                $title = preg_match("/(19[0-9][0-9]|20[0-9][0-9])/", $text, $year)?$year[0]:date('Y');
                $title = substr($text, 0, strpos($text, $title, stripos($text, 'Calen'))).$title;
                $this->calendars[$url] = new Calendar(
                    $url,
                    trim($title),
                    trim($text),
                    strtoupper(substr(strrchr($url, '.'), 1)),
                    $date
                );
            }
        }
    }

    /** @throws NotiffyException */
    public function extract()
    {
        for($i = 0; $i < count($this->links); ++$i) {
            $this->server($this->links[$i]->url);
            $response = $this->get('');
            
            // Get all links on page
            $this->links($response['content']);
            // Get all calendars on page
            $this->build();
            // Get only links of subpages
            $this->filter('calend');
            $this->clear();
        }
    }

    private function buildQuery(): string
    {
        $query = '';
        foreach($this->calendars as $calendar)
            $query .= "\r\nOR link='$calendar->link'";
        return 'SELECT link, date FROM '.UFJFCalendar::TABLE." WHERE \r\n".strpart($query, 'OR ');
    }

    /** @throws NotiffyException */
    public function validate()
    {
        try {
            Notiffy::log('Validating calendars in knowledge base.');

            $stmt = Notiffy::getDB()->Query($this->buildQuery());

            if ($stmt == false || $stmt->rowCount() < 0)
                throw new NotiffyException('Unable to validate in knowledge base.');

            foreach ($stmt->fetchAll() as $line) {
                $this->calendars[$line['link']]->new = false;
                $this->calendars[$line['link']]->date = new DateTime($line['date']);
            }
            Notiffy::log('Validation completed.');
        }catch(Exception $e) {
            throw new NotiffyException($e->getMessage());
        }
    }

    public function save()
    {
        if(Notiffy::TEST_MODE) {
            $this->testMode();
            return;
        }

        foreach($this->calendars as $calendar) {
            if(!$calendar->new)
                continue;

            $query = 'INSERT INTO '.UFJFCalendar::TABLE.' (link, title, date, type, description)'
                .'VALUES (:link, :title, :date, :type, :description);';
            $date  = $calendar->date->format('Y-m-d');

            $stmt = Notiffy::getDB()->prepare($query);
            $stmt->bindParam(':link',        $calendar->link);
            $stmt->bindParam(':title',       $calendar->title);
            $stmt->bindParam(':date',        $date);
            $stmt->bindParam(':type',        $calendar->type);
            $stmt->bindParam(':description', $calendar->description);
            $stmt->execute();

            Notiffy::log("News $calendar->title saved in knowledge base.");
            $this->new[] = $calendar->link;
        }
    }
}
