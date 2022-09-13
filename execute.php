<?php

require 'vendor/autoload.php';

use Dotenv\Dotenv;
use UFJFCalendar\UFJFCalendar;
use UFJFNews\UFJFNews;

Dotenv::createImmutable(__DIR__)->load();

$script = new  UFJFNews();
$script->execute();

$script = new UFJFCalendar();
$script->execute();
