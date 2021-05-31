<?php

namespace MElaraby\VCard\Properties;

class Role extends Property
{
    protected $role;

    /**
     * Role constructor.
     * @param string $role
     */
    public function __construct(string $role)
    {
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return "ROLE:{$this->role}";
    }
}
