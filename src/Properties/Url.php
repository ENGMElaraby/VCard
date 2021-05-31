<?php

namespace MElaraby\VCard\Properties;

class Url extends Property
{
    protected $url;

    /**
     * Url constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return "URL:{$this->url}";
    }
}
