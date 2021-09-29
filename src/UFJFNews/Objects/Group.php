<?php

namespace UFJFNews\Objects;

use UFJFNews\Extractors\MainStyleExtract;
use UFJFNews\Extractors\NewStyleExtract;
use UFJFNews\Extractors\OldStyleExtract;
use UFJFNews\Extractors\PagedStyleExtract;

class Group {
    public ?StyleExtract $extract = null;
    public ?int $new = null;

    public function __construct(
        public string $id,
        string  $design,
        public string  $name,
        string  $page,
        public string  $counter,
        public string  $icon,
    ) {
        $this->extract = match ($design) {
            'M' => new MainStyleExtract($page, $id),
            'N' => new NewStyleExtract($page, $id),
            'P' => new PagedStyleExtract($page, $id),
            'O' => new OldStyleExtract($page, $id),
        };
    }
}