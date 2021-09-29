<?php

namespace MailTest;

use DateTime;
use DateTimeInterface;
use Notiffy\Notiffy;
use Notiffy\NotiffyException;
use Notiffy\NotiffyScript;

class MailTest implements NotiffyScript
{
    private Notiffy $notiffy;

    public function __construct()
    {
        $this->notiffy = new Notiffy('mailtest', 'Mail Test', __DIR__ . '/views');
    }

    public function execute(): void
    {
        try {
            $body = $this->notiffy->blade->render('body');
            $this->notiffy->setBody(html_entity_decode($body));
            $this->notiffy->send('[Mail Test] '.(new DateTime('now'))->format(DateTimeInterface::RSS));
        }catch(NotiffyException $e) {
            $e->sendFailLog($this->notiffy);
        }
    }
}