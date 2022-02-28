<?php

declare(strict_types=1);


namespace MTK\Releaser\Change;

use Webmozart\Assert\Assert;

class Author
{
    private string $name;

    public function __construct(string $name)
    {
        Assert::stringNotEmpty($name, "Author should be not empty string");
        $this->name = $name;
    }

    public function __toString()
    {
        return $this->name;
    }
}
