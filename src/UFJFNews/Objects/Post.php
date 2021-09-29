<?php

namespace UFJFNews\Objects;

use DateTime;

class Post {
    public Category $category;

    public function __construct(
        public string   $id,
        public string   $title,
        public string   $design,
        public string   $group,
        public string   $link,
        public DateTime $date,
        public ?string  $thumbnail=null,
        public bool     $new=true,
    ) {}

    public function printDate(): string
    {
        $year = $this->date->format('Y');
        $day = $this->date->format('d');
        $month = match($this->date->format('m')) {
            '01' => 'janeiro',
            '02' => 'fevereiro',
            '03' => 'março',
            '04' => 'abril',
            '05' => 'maio',
            '06' => 'junho',
            '07' => 'julho',
            '08' => 'agosto',
            '09' => 'setembro',
            '10' => 'outubro',
            '11' => 'novembro',
            '12' => 'dezembro',
        };
        return "$day de $month de $year";
    }
}