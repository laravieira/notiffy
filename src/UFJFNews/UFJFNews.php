<?php

namespace UFJFNews;

use Notiffy\Notiffy;
use Notiffy\NotiffyException;
use Notiffy\NotiffyScript;
use UFJFNews\Objects\Group;

use const Notiffy\NOTIFFY_FAIL;

class UFJFNews implements NotiffyScript
{
    const NAME            = 'UFJF Newsletter';
    const ID              = 'ufjfnewsletter';
    const DATABASE_TABLE  = 'ufjf_newsletter';

    const REF_MAINPAGE    = array('UFJF',          'https://www.ufjf.br/');
    const REF_ERE         = array('Emergencial',   'https://www2.ufjf.br/ensinoremotoemergencial/');
    const REF_RU          = array('RU',            'https://www.ufjf.br/ru/');
    const REF_LIBRARY     = array('Biblioteca',    'https://www.ufjf.br/biblioteca/');
    const REF_ELETRIC     = array('Eng. Elétrica', 'https://www.ufjf.br/engenhariaeletrica/');
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


    private $notiffy;
    private $groups = array();

    public function __construct()
    {
        $this->setGroups();
        $this->notiffy = new Notiffy(self::ID, self::NAME, __DIR__ . '/views');
    }

    public function execute()
    {
        $new = 0;
        $throw = false;
        foreach($this->groups as $page) {
            try {
                $page->extract->extract();
                $page->extract->validate();
                $page->extract->savePosts();
                $page->extract->sortByDate();
                if($page->extract->hasNew())
                    $new += count($page->extract->new);
            }catch(NotiffyException $e) {
                Notiffy::log($e->getMessage(), NOTIFFY_FAIL);
                Notiffy::log($e->getFile().':'.$e->getLine(), NOTIFFY_FAIL);
                $throw = true;
            }
        }

        try {
            if($new) {
                $body = $this->notiffy->blade->render('body', array('groups' => $this->groups));
                $this->notiffy->setBody(html_entity_decode($body));
                $subject = ($new==1)?'1 Nova notícia':"$new Novas notícias";
                $this->notiffy->send('['.self::NAME.'] '.$subject);
            }
            if($throw)
                throw new NotiffyException('Throw detected in extrators.');
        }catch(NotiffyException $e) {
            sleep(10);
            $e->sendFailLog($this->notiffy);
        }
    }

    private function setGroups()
    {
        $this->groups[] = new Group(
            'MAIN',
            'M',
            'Gerais',
            'https://www2.ufjf.br/noticias/todas-as-noticias/',
            'Geral',
            'https://notiffy.laravieira.me/assets/ufjf_news/build.png'

        ); $this->groups[] = new Group(
            'ERE',
            'N',
            'Emergencial',
            'https://www2.ufjf.br/ensinoremotoemergencial/sitemap/',
            'ERE',
            'https://notiffy.laravieira.me/assets/ufjf_news/covid.png'

        ); $this->groups[] = new Group(
            'LIB',
            'N',
            'Biblioteca',
            'https://www2.ufjf.br/biblioteca/sitemap/',
            'Biblitc',
            'https://notiffy.laravieira.me/assets/ufjf_news/book.png'

        ); $this->groups[] = new Group(
            'RU',
            'P',
            'RU',
            'https://www2.ufjf.br/ru/?page_id=4&sitemap',
            'RU',
            'https://notiffy.laravieira.me/assets/ufjf_news/food.png'

        ); $this->groups[] = new Group(
            'ELT',
            'O',
            'Eng. Elétrica',
            'https://www.ufjf.br/engenhariaeletrica/noticias/',
            'Elétrc',
            'https://notiffy.laravieira.me/assets/ufjf_news/bold.png'

        ); $this->groups[] = new Group(
            'CDR',
            'N',
            'CDARA',
            'https://www2.ufjf.br/cdara/apresentacao/sitemap/',
            'CDARA',
            'https://notiffy.laravieira.me/assets/ufjf_news/registry.png'

        );$this->groups[] = new Group(
            'CONGRAD',
            'N',
            'CONGRAD',
            'https://www2.ufjf.br/congrad/sitemap/',
            'CONGRAD',
            'https://notiffy.laravieira.me/assets/ufjf_news/hammer.png'

        ); $this->groups[] = new Group(
            'PROGRAD',
            'N',
            'PROGRAD',
            'https://www2.ufjf.br/prograd/sitemap/',
            'PROGRAD',
            'https://notiffy.laravieira.me/assets/ufjf_news/hat.png'
        );
    }
}