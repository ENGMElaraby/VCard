<?php

namespace MElaraby\VCard\Properties;

class Org extends Property
{
    protected $team = null;
    protected $unit = null;
    protected $company = null;

    public function __construct(
        ?string $company = null,
        ?string $unit = null,
        ?string $team = null
    )
    {
        $this->company = $company;
        $this->unit = $unit;
        $this->team = $team;
    }

    public function __toString(): string
    {
        return "ORG:{$this->company};{$this->unit};{$this->team}";
    }
}
