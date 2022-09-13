<?php

namespace UFJFCalendar\Objects;

class Link {

    public $url;
    public $text;

    public function __construct(
        string $url,
        string $text
    ) {
        $this->text = $text;
        $this->url = $url;
    }
}