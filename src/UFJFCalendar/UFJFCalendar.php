<?php

namespace UFJFCalendar;

use Notiffy\Notiffy;
use Notiffy\NotiffyException;
use Notiffy\NotiffyScript;

class UFJFCalendar implements NotiffyScript
{
    const NAME  = 'UFJF Calendar';
    const ID    = 'ufjfcalendar';
    const TABLE = 'ufjf_calendar';
    const SHOW  = 9;

    const REF_CDARA       = array('CDARA',         'https://www2.ufjf.br/cdara/');
    const REF_CONGRAD     = array('CONGRAD',       'https://www2.ufjf.br/congrad/');
    const REF_PROGRAD     = array('PROGRAD',       'https://www2.ufjf.br/prograd/');

    const LARA_SITE       = array('Site Pessoal',  'https://laravieira.me');
    const LARA_FACEBOOK   = array('Facebook',      'https://fb.com/laravieira.me');
    const LARA_TWITTER    = array('Twitter',       'https://twitter.com/laravieirame');
    const LARA_GITHUB     = array('GitHub',        'https://github.com/laravieira');
    const LARA_MYSIGA     = array('MySIGA API',    'https://github.com/laravieira/MySIGA');

    const MORE_SIGA       = array('Siga',          'https://siga.ufjf.br');
    const MORE_MOODLE     = array('Moodle',        'https://ead.ufjf.br');
    const MORE_APP_BUSTIC = array('&nbsp;',        '#');
    const MORE_APP_SIGA   = array('&nbsp;',        '#');
    const MORE_APP_MOODLE = array('Moodle App',    'https://play.google.com/store/apps/details?id=com.moodle.moodlemobile');
    const MORE_APP_UFJF   = array('UFJF App',      'https://play.google.com/store/apps/details?id=br.ufjf.ufjfapp');


    private Notiffy $notiffy;
    private CalendarExtract $extract;

    public function __construct()
    {
        $this->notiffy = new Notiffy(self::ID, self::NAME, __DIR__ . '/views');

        $this->extract = new CalendarExtract();
        $this->extract->addLink('https://www2.ufjf.br/cdara/graduacao/calendario-academico/');
        $this->extract->addLink('https://www2.ufjf.br/prograd/institucional/calendarios-academicos/');
    }

    public function execute(): void
    {
        try {
            $this->extract->extract();
            $this->extract->sortByDate();
            $this->extract->validate();
            $this->extract->save();

            if(!$this->extract->hasNew())
                return;

            $data = array('calendars' => $this->extract->calendars);
            $body = $this->notiffy->blade->render('body', $data);
            $this->notiffy->setBody(html_entity_decode($body));
            $this->notiffy->send('['.self::NAME.'] Novo caléndário acadêmico publicado.');

        }catch(NotiffyException $e) {
            $e->sendFailLog($this->notiffy);
        }
    }
}