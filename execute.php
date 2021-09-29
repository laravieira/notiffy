<?php

require 'vendor/autoload.php';

use UFJFCalendar\UFJFCalendar;
use UFJFNews\UFJFNews;

$script = new  UFJFNews();
$script->execute();

$script = new UFJFCalendar();
$script->execute();
