<?php

namespace MElaraby\VCard\Properties;

class Title extends Property
{
    protected $title;

    /**
     * Title constructor.
     * @param string $title
     */
    public function __construct(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return "TITLE:{$this->title}";
    }
}
