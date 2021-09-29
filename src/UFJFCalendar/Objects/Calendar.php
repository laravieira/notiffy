<?php

namespace UFJFCalendar\Objects;

use DateTime;

class Calendar {

    public function __construct(
        public string $link,
        public string $title,
        public string $description,
        public string $type,
        public DateTime $date,
        public bool $new = true,
    ) {}
}