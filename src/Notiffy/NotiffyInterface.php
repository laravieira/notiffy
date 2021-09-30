<?PHP 

namespace Notiffy;

use Google\ApiCore\ApiException;
use Google\Cloud\RecaptchaEnterprise\V1\RecaptchaEnterpriseServiceClient;
use Google\Cloud\RecaptchaEnterprise\V1\Event;
use Google\Cloud\RecaptchaEnterprise\V1\Assessment;
use Google\Cloud\RecaptchaEnterprise\V1\TokenProperties\InvalidReason;
use Jenssegers\Blade\Blade;

class NotiffyInterface {
    public static Blade $blade;

    public static function setBlade(): void
    {
        self::$blade = new Blade(__DIR__ . '/views', Notiffy::BLADE_CACHE);
    }

    /** @throws NotiffyException */
    public static function home(): string
    {
        $data = array('newsletters' => Notiffy::newsletters());
        return self::$blade->render('home', $data);
    }

    /** @throws NotiffyException */
    public static function list(): void
    {
        header("Content-type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Origin: https://notiffy.laravieira.me");
        echo json_encode(Notiffy::newsletters());
    }

    /** @throws NotiffyException */
    public static function notFound(): void
    {
        http_response_code(404);
        throw new NotiffyException('404 Not Found.');
    }

    /** @throws NotiffyException */
    private static function reCaptcha(string $token): void
    {
        $path = __DIR__.'auth-recaptcha.json';
        if(!file_exists($path))
            file_put_contents($path, getenv('RECAPTCHA_CREDENTIALS'));
        putenv("GOOGLE_APPLICATION_CREDENTIALS=$path");

        $client = new RecaptchaEnterpriseServiceClient();

        $event = new Event();
        $event->setSiteKey(getenv('RECAPTCHA_KEY'));
        $event->setExpectedAction(Notiffy::RECAPTCHA_PROTECTED_ACTION);
        $event->setToken($token);

        $assessment = new Assessment();
        $assessment->setEvent($event);
        $assessment->setName(Notiffy::RECAPTCHA_ASSESSMENT_NAME);

        try {
            $response = $client->createAssessment(Notiffy::RECAPTCHA_PARENT_PROJECT, $assessment);
            if($response->getTokenProperties()->getValid() == false) {
                $reason = InvalidReason::name($response->getTokenProperties()->getInvalidReason());
                throw new NotiffyException($reason);

            }if($response->getEvent()->getExpectedAction() != Notiffy::RECAPTCHA_PROTECTED_ACTION) {
                throw new NotiffyException('[reCaptcha] Invalid action.');

            }if($response->getRiskAnalysis()->getScore() < 0.7)
                throw new NotiffyException('[reCaptcha] Are you a Bot?');
            
        }catch (ApiException $e) {
            throw new NotiffyException('[reCaptcha] '.$e->getMessage());
        }
    }

    /** @throws NotiffyException */
    public static function subscribe(): void
    {
        if(empty($_POST['name']))
            throw new NotiffyException('No user name.');
        if(empty($_POST['email']))
            throw new NotiffyException('No email address.');
        if(empty($_POST['newsletter']))
            throw new NotiffyException('No newsletter.');
        if(empty($_POST['g-recaptcha-response']))
            throw new NotiffyException('No reCaptcha Token.');
        
        $name       = $_POST['name'];
        $email      = $_POST['email'];
        $newsletter = $_POST['newsletter'];
        $recaptcha   = $_POST['g-recaptcha-response'];

        if(!preg_match('/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/', $email))
            throw new NotiffyException('Invalid email address.');
        $newsletters = Notiffy::newsletters();
        if(!isset($newsletters[$newsletter]))
            throw new NotiffyException('Invalid newsletter id.');
        
        self::reCaptcha($recaptcha);

        Notiffy::addRecipient($newsletter, $name, $email, false);

        // This is not an exception
        throw new NotiffyException('Successfully subscribed.');
    }

    /** @throws NotiffyException */
    public static function unsubscribe(array $vars) {
        if(empty($vars['n']))
            throw new NotiffyException('No newsletter name.');
        if(empty($vars['k']))
            throw new NotiffyException('No recipient key.');

        Notiffy::removeRecipient($vars['n'], $vars['k']);

        // This is not an exception
        throw new NotiffyException('You will no longer receive emails from this newsletter.');
    }

}