<?php

declare(strict_types=1);

namespace Ngmy\L4Dav;

class PropfindParameters
{
    /** @var Depth */
    private $depth;

    public function __construct(?Depth $depth = null)
    {
        $this->depth = $depth ?: new Depth();
    }

    public function depth(): Depth
    {
        return $this->depth;
    }
}