<?PHP 

/* Created by: Lara Vieira - https://laravieira.me
 * Description: Simple way to do web-scraping with PHP 8.
 * 
 * Overview:
 * 
 * upname($name)
 *      Return formated string to name format (uppercase the fisrt letter of each word, skipping 'de', 'of', 'com', 'I', 'II', 'III', 'V')
 * 
 * price($price)
 *      Return float value of a price on a string. A string 'US$: 3.450.44' will return a float 3450.44;
 * 
 * on($string, $start, $substart)
 *      Return part of an string starting with $start of $substart (if given);
 *      If $subStart was given, $start will be search first and $subStart will the searched with $start search result;
 *      Example1: on('ABAD', 'A'); will return 'AB';
 *      Example2: on('ABAD', 'B'); will return 'BCD';
 *      Example3: on('ABAD', 'B', 'A'); will return 'AD';

 * in($string, $start, $end, $keep_start)
 *      Return part of an string starting on $start and ending before $end (if given);
 *      If $keep_start was true, $start will remain on result, if false (default), $start will be removed from result;
 *      Example1: in('ABAD', 'A'); will return 'BAD';
 *      Example2: in('ABAD', 'A', 'D'); will return 'BA';
 *      Example3: in('ABAD', 'A', 'D', true); will return 'ABA';
 * 
 * Scraping::cache($name, $cache, $expire)
 *      Make an cache in .json file of $cache mixed data with name $name with expiration in $expire time;
 *      $name: string constains the cache name/id;
 *      $cache: data to be cached, if not passed, will return cache already saved or null;
 *      $expire: string of parse DateInterval. Expire time of the cache, is optional, default is 'P1D' (1 day);
 * 
 * Scraping::json($data, $code)
 *      Return nothing, set header 'Content-type' to 'application/json' and print $data as json parsed string;
 *      $data: mixed data to be printed as json parsed string. If null will be printed 'false' with HTTP 500 code;
 *      $code: int, HTTP response code, default is 200;
 * 
 * Scraping($server, $userAgent, $useSession, $sessionName)
 *      Create Scraping instance.
 *      $server: string with server link to connect;
 *      $userAgent: value of header "User-agent", default is 'Scraping/version';
 *      $useSession: bool value, set to true if you need to keep login based on session;
 *      $sessionName: string with cookie name of the session, default is 'PHPSESSID';
 * 
 * Scraping->get($uri, $headers)
 *      Make an connection with $server on path $uri of type HTTP GET;
 *      $uri: string path of link to connect on https://bit.ly/dargg, the server is https:/bit.ly and the path ($uri) is /dargg
 *      $headers: bool to ask for header processing and return, default is true, has to be true if $useSession is true;
 * 
 * Scraping->post($uri, $post, $header, $headers)
 *      Make an connection with $server on path $uri of type HTTP POST;
 *      $uri: string path of link to connect on https://bit.ly/dargg, the server is https:/bit.ly and the path ($uri) is /dargg
 *      $post: array with post data to be send;
 *      $header: array of header lines to increment on the request;
 *      $headers: bool to ask for header processing and return, default is true, has to be true if $useSession is true;
 * 
 * Scraping::cacheFolder($folder)
 *      Returns cache folder;
 *      $folder: string with relative path of __DIR__. Is optional, dafult is '/cache', so the cache will be saved at '__DIR__/cache/[cache_name].json';
 * 
 * Scraping->useSession($useSession)
 *      Return bool Scrapping::$useSession;
 *      $useSession: bool if given will set Scrapping::$useSession;

 * Scraping->session($session)
 *      Return server session id Scrapping::$session;
 *      $session: string if given will set Scrapping::$session;

 * Scraping->server($server)
 *      Return server link Scrapping::$server;
 *      $server: string if given will set Scrapping::$server;
 * 
 * Scraping->userAgent($userAgent)
 *      Return string Scrapping::$userAgent;
 *      $userAgent: string if given will set Scrapping::$userAgent;
 * 
*/

namespace Scraping;


use DateInterval;
use DateTime;
use DateTimeInterface;
use Exception;

class Scraping {
    const SCRAPING_NAME    = 'Scraping';
    const SCRAPING_VERSION = '1.0.0';
    const SCRAPING_CACHE   = '/cache';

    private static string $cacheFolder = self::SCRAPING_CACHE;
    private string $session;

    /** @throws Exception */
    public static function cache(string $name, mixed $cache=null, string $expire=null): mixed
    {
        $expire = $expire ?? 'P1D'; // Expire in 1 day

        $file = __DIR__ . self::$cacheFolder .$name.'.json';

        if(!file_exists(pathinfo($file)['dirname']))
            if(mkdir(pathinfo($file)['dirname'], recursive:true))
                return null;
        
        if(isset($cache))
            file_put_contents($file, json_encode(array(
                'total' => count($cache),
                'updated' => (new DateTime('now'))->format(DateTimeInterface::RSS),
                'expire' => (new DateTime('now'))->add(new DateInterval($expire))->format(DateTimeInterface::RSS),
                $name => $cache,
            )));

        if(!file_exists($file))
            return null;
        
        $filem = (new DateTime())->setTimestamp(filemtime($file));
        $filex = (new DateTime('now'))->sub(new DateInterval($expire));

        if($filem > $filex)
            return json_decode(file_get_contents($file));
        else
            return null;
    }

    public static function cacheFolder(string $folder=null): string
    {
        return self::$cacheFolder = $folder ?? self::$cacheFolder;
    }

    public static function json(mixed $data, int $code=200): void
    {
        header('Content-Type: application/json');
        http_response_code($code);
        if(isset($data))
            echo json_encode($data);
    }

    public static function isOnSession(): bool
    {
        return (isset($_SESSION['scraping']) && $_SESSION['scraping'] instanceof Scraping);
    }

    public static function load(Scraping $scraping=null) {
        if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
        if(isset($scraping))
            $_SESSION['scraping'] = $scraping;
        if(isset($_SESSION['scraping']) && $_SESSION['scraping'] instanceof Scraping)
            return $_SESSION['scraping'];
        session_destroy();
        return null;
    }

    public function __construct(
        private string $server,
        private string $userAgent   = Scraping::SCRAPING_NAME.'/'.Scraping::SCRAPING_VERSION,
        private bool   $useSession  = false,
        private string $sessionName = 'PHPSESSID',
    ) {
        if($useSession && session_status() != PHP_SESSION_ACTIVE)
            session_start();
        self::$cacheFolder = self::SCRAPING_CACHE;
    }

    public function useSession(bool $useSession=null): bool
    {
        return $this->useSession = $useSession ?? $this->useSession;
    }
    
    public function userAgent(string $userAgent=null): string
    {
        return $this->userAgent = $userAgent ?? $this->userAgent;
    }
    
    public function server(string $server=null): string
    {
        return $this->server = $server ?? $this->server;
    }
    
    public function session(string $session=null): string
    {
        return $this->session = $session ?? $this?->session;
    }
    
    private function hasSession(): bool
    {
        return $this->useSession && isset($this->session);
    }
    
    private function sessionName(string $sessionName=null): string
    {
        return $this->sessionName = $sessionName ?? $this->sessionName;
    }

    public function get(string $uri, bool $headers=false): array
    {

        $session = $this->hasSession()?array('Cookie: '.$this->sessionName.'='.$this->session):array();

        $request = curl_init($this->server.$uri);
        curl_setopt($request, CURLOPT_COOKIESESSION,  $this->useSession);
        curl_setopt($request, CURLOPT_HTTPHEADER,     $session);
        curl_setopt($request, CURLINFO_HEADER_OUT,    $headers);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_HEADER,         $headers);
        curl_setopt($request, CURLOPT_AUTOREFERER,    true);
        curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($request, CURLOPT_USERAGENT,      $this->userAgent);
        $content = curl_exec($request);

        $data['request'] = $headers?trim(curl_getinfo($request, CURLINFO_HEADER_OUT)):false;
        $data['header']  = $headers?trim(stristr($content, "\r\n\r\n", true)):false;
        $data['content'] = $headers?trim(stristr($content, "\r\n\r\n")):trim($content);
        $data['url']     = curl_getinfo($request, CURLINFO_EFFECTIVE_URL);
        $data['code']    = curl_getinfo($request, CURLINFO_HTTP_CODE);
        curl_close($request);

        return $this->proccess($data, $headers);
    }

    public function post(string $uri, array $data, array $header=null, bool $headers=false): array
    {

        $sendHeader = $this->hasSession()?array('Cookie: '.$this->sessionName.'='.$this->session):array();
        if(isset($header)) foreach($header as $key => $value)
            $sendHeader[] = $key.': '.$value;

        $request = curl_init($this->server.$uri);
        curl_setopt($request, CURLOPT_COOKIESESSION,  $this->useSession);
        curl_setopt($request, CURLOPT_POST,           true);
        curl_setopt($request, CURLOPT_POSTFIELDS,     http_build_query($data));
        curl_setopt($request, CURLOPT_HTTPHEADER,     $sendHeader);
        curl_setopt($request, CURLINFO_HEADER_OUT,    $headers);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_HEADER,         $headers);
        curl_setopt($request, CURLOPT_AUTOREFERER,    true);
        curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($request, CURLOPT_USERAGENT,      $this->userAgent);
        $content = curl_exec($request);
        
        $outdata['request'] = $headers?trim(curl_getinfo($request, CURLINFO_HEADER_OUT)):false;
        $outdata['header']  = $headers?trim(stristr($content, "\r\n\r\n", true)):false;
        $outdata['content'] = $headers?trim(stristr($content, "\r\n\r\n")):trim($content);
        $outdata['url']     = curl_getinfo($request, CURLINFO_EFFECTIVE_URL);
        $outdata['code']    = curl_getinfo($request, CURLINFO_HTTP_CODE);
        $outdata['data']    = $data;
        curl_close($request);

        return $this->proccess($outdata, $headers);
    }

    private function proccess(array $data, bool $headers): array
    {
        if(!$headers)
            return $data;
            
        $data['cookies'] = array();
        preg_match_all("/^Set-Cookie:\s*([^;]*)/mi", $data['header'], $matches);
        foreach($matches[1] as $item) {
            parse_str($item, $cookie);
            $data['cookies'] = array_merge($data['cookies'], $cookie);
        }

        // Interpret each line of request header
        $lines = explode("\r\n", $data['request']);
        $data['request'] = array();
        $data['request']['method']   = explode(' ', $lines[0])[0];
        $data['request']['path']     = explode(' ', $lines[0])[1];
        $data['request']['protocol'] = explode(' ', $lines[0])[2];
        foreach($lines as $line)
            $data['request'][strstr($line, ':', true)] = trim(substr(strstr($line, ':'), 1));
        
        // Interpret each line of response header
        $lines = explode("\r\n", $data['header']);
        $data['header'] = array();
        $data['header']['method']   = explode(' ', $lines[0])[0];
        $data['header']['path']     = explode(' ', $lines[0])[1];
        $data['header']['protocol'] = explode(' ', $lines[0])[2];
        foreach($lines as $line)
            $data['header'][strstr($line, ':', true)] = trim(substr(strstr($line, ':'), 1));
        
        // Update Server session id
        if($this->useSession && count($data['cookies'])) {
            if(array_search('PHPSESSID', $data['cookies']) !== false) {
                $_SESSION['session'] = $data['cookies']['PHPSESSID'];
                $this->session = $data['cookies']['PHPSESSID'];
            }
        }

        return $data;
    }

}

function upname(string $name): string
{
    $words = explode(' ', $name);
    $name = '';
    foreach($words as $word) {
        if($word == 'I' || $word == 'II' || $word == 'III' || $word == 'IV' || $word == 'V' || $word == 'VI')
            $name .= ' '.$word;
        else if(strlen($word) < 3)
            $name .= ' '.mb_strtolower($word);
        else
            $name .= ' '.mb_convert_case($word, MB_CASE_TITLE, 'UTF-8');
    }
    return substr($name, 1);
}

function price(string $string): float
{
    return floatval(str_replace(',', '.', str_replace('.', '', substr(strstr($string, ' '), 1))));
}

function accents(string $string): string
{
    return strtr(utf8_decode($string), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
}

function strmstr(string $string, string $start1, string $start2, string $start3=null): bool|string
{
    $string = !empty($start1)?strstr($string, $start1):$string;
    $string = !empty($start2)?strstr($string, $start2):$string;
    return    !empty($start3)?strstr($string, $start3):$string;
}

function strpart(string $string, string $start=null, string $end=null, bool $keep_start=false): bool|string
{
    $string = !empty($start)?strstr($string, $start):$string;
    $string = (!empty($start) && !$keep_start)?substr($string, strlen($start)):$string;
    $string = !empty($end)?strstr($string, $end, true):$string;
    return $string;
}

function strmpart(string $string, string $start1, string $start2, string $end=null, bool $keep_start=false): bool|string
{
    $string = !empty($start1)?strstr($string, $start1):$string;
    $string = !empty($start2)?strstr($string, $start2):$string;
    $string = (!empty($start2) && !$keep_start)?substr($string, strlen($start2)):$string;
    $string = !empty($end)?strstr($string, $end, true):$string;
    return $string;
}

?>