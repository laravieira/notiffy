<?php

namespace UFJFCalendar\Objects;

class Link {

    public function __construct(
        public string $url,
        public string $text,
    ) {}
}