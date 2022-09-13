<?php

namespace UFJFNews\Objects;

class Category
{
    public $name;
    public $link = null;
    public $color = null;

    public function __construct(
        string $name,
        string $link = null,
        string $color = null
    ) {
        $this->color = $color;
        $this->link = $link;
        $this->name = $name;
    }
}