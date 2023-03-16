<?PHP

namespace Notiffy;

use DateTime;
use DateTimeInterface;
use PDO;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Jenssegers\Blade\Blade;

const NOTIFFY_INFO = '[INFO] ';
const NOTIFFY_WARN = '[WARN] ';
const NOTIFFY_FAIL = '[FAIL] ';

class Notiffy {

    // Basic
    const NAME        = 'Notiffy';
    const VERSION     = '2.1.1';
    const PAGE        = 'https://notiffy.laravieira.me/';
    const UNSUBSCRIBE = 'https://notiffy.laravieira.me/unsubscribe';
    const GITHUB      = 'https://github.com/laravieira/notiffy';
    const TEST_MODE   = false;
    const TIMEZONE    = 'America/Sao_Paulo';
    const TIMEOUT     = 0;
    const BLADE_CACHE = __DIR__ . '/cache';

    // Recaptcha
    const RECAPTCHA_ASSESSMENT_NAME  = 'Notiffy Subscribe';
    const RECAPTCHA_PROTECTED_ACTION = 'SOCIAL';
    const RECAPTCHA_PARENT_PROJECT   = 'projects/notiffy';

    // Email config
    const EMAIL_CHARSET = 'UTF-8';
    const EMAIL_ISHTML  = true;

    private static array  $logs = array();
    private static string $nbsp;
    private static ?PDO $db = null;
    private array  $emails = array();
    private array  $admins = array();
    private string $body;
    private string $fail;
    public  Blade  $blade;

    public static function getDB(): ?PDO
    {
        if(!isset(self::$db)) {
            $host = getenv('DB_HOST');
            $port = getenv('DB_PORT');
            $name = getenv('DB_NAME');
            $user = getenv('DB_USER');
            $pass = getenv('DB_PASS');
            self::$db = new PDO("mysql:host=$host;port=$port;dbname=$name", $user, $pass);
        }if(self::TEST_MODE)
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$db;
    }

    public function __construct(
        private string $newsletter,
        private string $newsletterName,
        string $views,
    ) {

        date_default_timezone_set(self::TIMEZONE);
        set_time_limit(self::TIMEOUT);
        
        $this::$nbsp = PATH_SEPARATOR == ";"?"\r\n":"\n";
        $this::$nbsp = self::TEST_MODE?"<br>":$this::$nbsp;
        $this->blade = new Blade($views, self::BLADE_CACHE);
        
        $this->log(self::NAME.' '.self::VERSION);
        $this->log("Newsletter: $newsletter");
        if(self::TEST_MODE)
            $this->log("TEST MODE ENABLED !!!", NOTIFFY_WARN);
        $this->log("Time: ".(new DateTime('now'))->format(DateTimeInterface::RSS));
        $this->log("------------------------------------");
        
        $this->loadRecipients();
    }

    public static function log($message, $type=NOTIFFY_INFO): void
    {
        if(self::TEST_MODE)
            echo "<p style='margin: 0'>".$type.$message."</p>";
        else
            echo $type.$message.self::$nbsp;
        self::$logs[] = $type.$message;
    }

    public static function getLogStack(): array
    {
        return self::$logs;
    }

    /** @throws NotiffyException */
    public static function newsletters(): array
    {
        $stmt = self::getDB()->query('SELECT id, name, description FROM newsletters;');
        if($stmt == false || $stmt->rowCount() < 1)
            throw new NotiffyException('Error when loadings newsletters.');
        
        $newsletters = array();
        foreach($stmt->fetchAll() as $recipient) {
            $newsletters[$recipient['id']] = array(
                'id'   => $recipient['id'],
                'name' => $recipient['name'],
                'description' => $recipient['description'],
            );
        }
        return $newsletters;
    }

    public static function addRecipient(string $newsletter, string $name, string $email, bool $admin): bool
    {
        $query = "SELECT * FROM recipients WHERE newsletter =:news AND email=:email;";
        $stmt = self::getDB()->prepare($query);
        $stmt->bindParam(':news', $newsletter);
        $stmt->bindParam(':email',      $email);
        $stmt->execute();
        if($stmt->rowCount() < 0 || $stmt->rowCount() > 1)
            return false;
        if($stmt->rowCount() == 1)
            return true;
        
        $date = (new DateTime('now'))->format('Y-m-d');
        $key = md5("$date-$name-$email-".rand(999, 999999));
        $stmt = self::getDB()->prepare('INSERT INTO recipients (name, email, admin, newsletter, `key`, date) VALUES (:name, :email, :admin, :newsletter, :key, :date);');
        $stmt->bindParam(':name',       $name);
        $stmt->bindParam(':email',      $email);
        $stmt->bindParam(':admin',      $admin);
        $stmt->bindParam(':newsletter', $newsletter);
        $stmt->bindParam(':key',        $key);
        $stmt->bindParam(':date',       $date);
        $stmt->execute();
        return true;
    }

    public static function removeRecipient(string $newsletter, string $key): bool
    {
        $stmt = self::getDB()->prepare('DELETE FROM recipients WHERE `key`=:key AND newsletter=:news;');
        $stmt->bindParam(':key',  $key);
        $stmt->bindParam(':news', $newsletter);
        $stmt->execute();
        if($stmt->rowCount() < 1 || $stmt->rowCount() > 1)
            return false;
        return true;
    }

    private function loadRecipients(): void
    {
        $stmt = $this::getDB()->query("SELECT name, email, `key`, admin FROM recipients WHERE newsletter='{$this->newsletter}';");
        if($stmt == false || $stmt->rowCount() < 1) {
            $this->log('No recipients loaded.', NOTIFFY_WARN);
            return;
        }
        
        foreach($stmt->fetchAll() as $recipient) {
            $this->emails[] = array(
                'name'  => $recipient['name'],
                'email' => $recipient['email'],
                'key'   => $recipient['key'],
            );
            if($recipient['admin'])
                $this->admins[] = array(
                    'name'  => $recipient['name'],
                    'email' => $recipient['email'],
                    'key'   => $recipient['key'],
                );
        }
        $this->log($stmt->rowCount().' recipients loaded.');
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function setFail(string $body): void
    {
        $this->fail = $body;
    }

    private function addUnsubscribeEmail(string &$body, string $key): array|string
    {
        return str_replace(self::UNSUBSCRIBE, self::UNSUBSCRIBE."/$this->newsletter/".$key, $body);
    }

    /** @throws Exception */
    private function sendMail(PHPMailer $mail, string &$body, string $subject, string $name, string $address, string $key): bool
    {
        $mail->ClearAddresses();
        $mail->ClearCustomHeaders();
        $mail->AddAddress($address, $name);
        $unsubscribe = '<'.self::UNSUBSCRIBE.'>';
        $mail->addCustomHeader("Content-Disposition", "inline");
        $mail->addCustomHeader("List-Unsubscribe", $this->addUnsubscribeEmail($unsubscribe, $key));
        $mail->Subject = $subject;
        $mail->Body = $this->addUnsubscribeEmail($body, $key);
        return $mail->send();
    }

    /** @throws NotiffyException */
    public function send(string $subject=null, bool $fail=false) {
        try {
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = getenv('SMTP_HOST');
            $mail->Port = getenv('SMTP_PORT');
            $mail->SMTPKeepAlive = true;
            $mail->SMTPAuth = true;
            $mail->Username = getenv('SMTP_USER');
            $mail->Password = getenv('SMTP_PASS');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            $mail->XMailer = self::NAME . ' ' . self::VERSION;
            $mail->CharSet = self::EMAIL_CHARSET;
            $mail->Encoding = 'base64';

            $mail->setFrom(getenv('SMTP_USER'), self::NAME);
            $mail->addReplyTo(getenv('SMTP_USER'), self::NAME);
            $mail->isHTML(self::EMAIL_ISHTML);

            $count = 0;
            if (self::TEST_MODE) {
                echo 'Subject: ' . $subject . $this::$nbsp;
                echo 'Showing the email: ' . $this::$nbsp . $this::$nbsp . ($fail ? $this->fail : $this->body);
                return;

            } elseif ($fail) foreach ($this->admins as $to) {
                $subject = $subject ?? '[' . self::NAME . "][ERROR] $this->newsletterName";
                if (!$this->sendMail($mail, $this->fail, $subject, $to['name'], $to['email'], $to['key']))
                    break;
                $count++;
            }
            else foreach ($this->emails as $to) {
                $subject = $subject ?? '[' . self::NAME . "] $this->newsletterName";
                if (!$this->sendMail($mail, $this->body, $subject, $to['name'], $to['email'], $to['key']))
                    throw new NotiffyException('Can\'t send emails.');
                $count++;
            }

            if ($fail && ($count < count($this->admins)))
                $this::log('Error on send fail emails.');
            elseif ($fail)
                $this::log('Fail log sended to ' . $count . ' recipients.');
            else
                $this::log('Emails sended to ' . $count . ' recipients.');
        }catch(Exception $e) {
            throw new NotiffyException($e->getMessage());
        }
    }
}