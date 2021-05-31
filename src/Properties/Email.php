<?php

namespace MElaraby\VCard\Properties;

class Email extends Property
{
    public const INTERNET = 'INTERNET';

    public const WORK = 'WORK';

    protected $types;

    protected $email;

    /**
     * Email constructor.
     * @param string $email
     * @param array $types
     */
    public function __construct(string $email, array $types)
    {
        $this->email = $email;
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

        return "EMAIL;$types:$this->email";
    }
}
