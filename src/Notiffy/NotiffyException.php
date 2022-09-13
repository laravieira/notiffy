<?php

namespace Notiffy;

use Exception;

class NotiffyException extends Exception {
    public function sendFailLog(Notiffy $notiffy) {
        try {
            Notiffy::log($this->getMessage(), NOTIFFY_FAIL);
            Notiffy::log($this->getFile().':'.$this->getLine(), NOTIFFY_FAIL);
            $body = $notiffy->blade->render('fail', array('logs' => Notiffy::getLogStack()));
            $notiffy->setFail(html_entity_decode($body));
            $notiffy->send(null, true);
        } catch (NotiffyException $e) {
            echo $e->getMessage();
        }
    }
}