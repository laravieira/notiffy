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


    private Notiffy $notiffy;
    private array $groups = array();

    public function __construct()
    {
        $this->setGroups();
        $this->notiffy = new Notiffy(self::ID, self::NAME, __DIR__ . '/views');
    }

    public function execute(): void
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

    private function setGroups():void
    {
        $this->groups[] = new Group(
            id:      'MAIN',
            design:  'M',
            name:    'Gerais',
            page:    'https://www2.ufjf.br/noticias/todas-as-noticias/',
            counter: 'Geral',
            icon:    'https://notiffy.laravieira.me/assets/Extractors/build.png',

        ); $this->groups[] = new Group(
            id:      'ERE',
            design:  'N',
            name:    'Emergencial',
            page:    'https://www2.ufjf.br/ensinoremotoemergencial/sitemap/',
            counter: 'ERE',
            icon:    'https://notiffy.laravieira.me/assets/Extractors/covid.png',

        ); $this->groups[] = new Group(
            id:      'LIB',
            design:  'N',
            name:    'Biblioteca',
            page:    'https://www2.ufjf.br/biblioteca/sitemap/',
            counter: 'Biblitc',
            icon:    'https://notiffy.laravieira.me/assets/Extractors/book.png',

        ); $this->groups[] = new Group(
            id:      'RU',
            design:  'P',
            name:    'RU',
            page:    'https://www2.ufjf.br/ru/?page_id=4&sitemap',
            counter: 'RU',
            icon:    'https://notiffy.laravieira.me/assets/Extractors/food.png',

        ); $this->groups[] = new Group(
            id:      'ELT',
            design:  'O',
            name:    'Eng. Elétrica',
            page:    'https://www.ufjf.br/engenhariaeletrica/noticias/',
            counter: 'Elétrc',
            icon:    'https://notiffy.laravieira.me/assets/Extractors/bold.png',

        ); $this->groups[] = new Group(
            id:      'CDR',
            design:  'N',
            name:    'CDARA',
            page:    'https://www2.ufjf.br/cdara/apresentacao/sitemap/',
            counter: 'CDARA',
            icon:    'https://notiffy.laravieira.me/assets/Extractors/registry.png',

        );$this->groups[] = new Group(
            id:      'CONGRAD',
            design:  'N',
            name:    'CONGRAD',
            page:    'https://www2.ufjf.br/congrad/sitemap/',
            counter: 'CONGRAD',
            icon:    'https://notiffy.laravieira.me/assets/Extractors/hammer.png',

        ); $this->groups[] = new Group(
            id:      'PROGRAD',
            design:  'N',
            name:    'PROGRAD',
            page:    'https://www2.ufjf.br/prograd/sitemap/',
            counter: 'PROGRAD',
            icon:    'https://notiffy.laravieira.me/assets/Extractors/hat.png',
        );
    }
}