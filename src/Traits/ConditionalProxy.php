<?php

namespace MElaraby\VCard\Traits;

class ConditionalProxy
{
    protected $object, $condition;

    /**
     * ConditionalProxy constructor.
     * @param $object
     * @param bool $condition
     */
    public function __construct($object, bool $condition)
    {
        $this->object = $object;
        $this->condition = $condition;
    }

    /**
     * @param $name
     * @param $arguments
     * @return false|mixed|object
     */
    public function __call($name, $arguments)
    {
        if ($this->condition) {
            return call_user_func_array([$this->object, $name], $arguments);
        }

        return $this->object;
    }
}
