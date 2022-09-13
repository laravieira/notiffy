<?php

namespace Notiffy;

use UFJFCalendar\UFJFCalendar;
use UFJFNews\UFJFNews;

class NotiffyExecuter
{
    public static function execute(): void
    {
        $script = new  UFJFNews();
        $script->execute();

        $script = new UFJFCalendar();
        $script->execute();
    }
}
