<?php

namespace MElaraby\VCard\Properties;

abstract class Property
{
    /**
     * @return string
     */
    abstract public function __toString(): string;
}
