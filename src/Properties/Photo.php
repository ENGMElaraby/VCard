<?php

namespace MElaraby\VCard\Properties;

class Photo extends Property
{
    protected $photo;

    /**
     * Photo constructor.
     * @param string $photo
     */
    public function __construct(string $photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return "PHOTO:{$this->photo}";
    }
}
