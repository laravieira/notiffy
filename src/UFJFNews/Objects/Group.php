<?php

namespace UFJFNews\Objects;

use UFJFNews\Extractors\MainStyleExtract;
use UFJFNews\Extractors\NewStyleExtract;
use UFJFNews\Extractors\OldStyleExtract;
use UFJFNews\Extractors\PagedStyleExtract;

class Group {
    public $extract = null;
    public $new = null;
    public $id;
    public $name;
    public $counter;
    public $icon;

    public function __construct(
        string $id,
        string $design,
        string $name,
        string $page,
        string $counter,
        string $icon
    ) {
        $this->icon = $icon;
        $this->counter = $counter;
        $this->name = $name;
        $this->id = $id;
        switch($design) {
            case 'M': $this->extract = new MainStyleExtract($page, $id); break;
            case 'N': $this->extract = new NewStyleExtract($page, $id); break;
            case 'P': $this->extract = new PagedStyleExtract($page, $id); break;
            case 'O': $this->extract = new OldStyleExtract($page, $id); break;
        };
    }
}