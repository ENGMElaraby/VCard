<?php

namespace MElaraby\VCard\Properties;

use DateTimeInterface;

class BirthDay extends Property
{
    protected $birthDay;

    /**
     * BirthDay constructor.
     * @param DateTimeInterface $birthDay
     */
    public function __construct(DateTimeInterface $birthDay)
    {
        $this->birthDay = $birthDay;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return "BDAY:{$this->birthDay->format('Y-m-d')}";
    }
}
