<?php

namespace MElaraby\VCard\Properties;

class Kind extends Property
{
    public const INDIVIDUAL = 'individual';

    public const ORGANIZATION = 'organization';

    public const GROUP = 'group';

    protected $kind;

    /**
     * Kind constructor.
     * @param string $kind
     */
    public function __construct(string $kind)
    {
        $this->kind = $kind;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return "KIND:{$this->kind}";
    }
}
