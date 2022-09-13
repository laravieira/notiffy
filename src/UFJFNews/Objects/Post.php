<?php

namespace UFJFNews\Objects;

use DateTime;

class Post {
    public $category;
    public $id;
    public $title;
    public $design;
    public $group;
    public $link;
    public $date;
    public $new = true;
    public $thumbnail = null;

    public function __construct(
        string $id,
        string $title,
        string $design,
        string $group,
        string $link,
        DateTime $date,
        string $thumbnail=null,
        bool $new=true
    ) {
        $this->thumbnail = $thumbnail;
        $this->new = $new;
        $this->date = $date;
        $this->link = $link;
        $this->group = $group;
        $this->design = $design;
        $this->title = $title;
        $this->id = $id;
    }

    public function printDate(): string
    {
        $year = $this->date->format('Y');
        $day = $this->date->format('d');
        switch($this->date->format('m')) {
            case '01': $month = 'janeiro'; break;
            case '02': $month = 'fevereiro'; break;
            case '03': $month = 'março'; break;
            case '04': $month = 'abril'; break;
            case '05': $month = 'maio'; break;
            case '06': $month = 'junho'; break;
            case '07': $month = 'julho'; break;
            case '08': $month = 'agosto'; break;
            case '09': $month = 'setembro'; break;
            case '10': $month = 'outubro'; break;
            case '11': $month = 'novembro'; break;
            case '12': $month = 'dezembro'; break;
        };
        return "$day de $month de $year";
    }
}