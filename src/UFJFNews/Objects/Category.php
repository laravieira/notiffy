<?php

namespace UFJFNews\Objects;

class Category
{
    public function __construct(
        public string $name,
        public ?string $link = null,
        public ?string $color = null,
    ) {}
}