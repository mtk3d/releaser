<?php


namespace MTK\Releaser\Change;

use Webmozart\Assert\Assert;

class Author
{
    /**
     * @var string
     */
    private string $name;

    /**
     * Author constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        Assert::stringNotEmpty($name, "Author should be not empty string");
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
