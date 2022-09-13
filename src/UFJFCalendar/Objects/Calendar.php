<?php

namespace UFJFCalendar\Objects;

use DateTime;

class Calendar {

    public $link;
    public $title;
    public $description;
    public $type;
    public $date;
    public $new = true;

    public function __construct(
        string $link,
        string $title,
        string $description,
        string $type,
        DateTime $date,
        bool $new = true
    ) {
        $this->new = $new;
        $this->date = $date;
        $this->type = $type;
        $this->description = $description;
        $this->title = $title;
        $this->link = $link;
    }
}