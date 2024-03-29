<?php

declare(strict_types=1);


namespace MTK\Releaser\Change;

class Author
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function __toString()
    {
        return $this->name;
    }
}
