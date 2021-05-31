<?php

namespace MElaraby\VCard\Properties;

class Gender extends Property
{
    public const FEMALE = 'F';

    public const MALE = 'M';

    protected $gender;

    /**
     * Gender constructor.
     * @param string $gender
     */
    public function __construct(string $gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return "GENDER:{$this->gender}";
    }
}
