<?php

namespace MElaraby\VCard\Properties;

class Tel extends Property
{
    public const VOICE = 'VOICE';

    public const WORK = 'WORK';

    public const HOME = 'HOME';

    public const CELL = 'CELL';

    protected $types;

    protected $number;

    /**
     * Tel constructor.
     * @param string $number
     * @param array $types
     */
    public function __construct(string $number, array $types)
    {
        $this->number = $number;
        $this->types = $types;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $types = implode(';', array_map(
            function (string $type): string {
                return "TYPE={$type}";
            },
            $this->types
        ));

        return "TEL;$types:$this->number";
    }
}
