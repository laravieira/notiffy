<?php

require 'vendor/autoload.php';

use UFJFCalendar\UFJFCalendar;
use UFJFNews\UFJFNews;

// Send an empty mail.
//$script = new \MailTest\MailTest();
//$script->execute();

$script = new  UFJFNews();
$script->execute();

$script = new UFJFCalendar();
$script->execute();
