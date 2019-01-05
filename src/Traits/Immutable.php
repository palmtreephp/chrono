<?php

namespace Palmtree\Chrono\Traits;

trait Immutable
{
    abstract public function createClone();

    /**
     * @param int    $value
     * @param string $period
     *
     * @return self
     */
    public function add(int $value, string $period)
    {
        return $this->cloneCall(__FUNCTION__, \func_get_args());
    }

    /**
     * @param int    $value
     * @param string $period
     *
     * @return self
     */
    public function subtract(int $value, string $period)
    {
        return $this->cloneCall(__FUNCTION__, \func_get_args());
    }

    protected function cloneCall($method, $params = [])
    {
        $clone = $this->createClone();

        $closure = function () use ($method, $params) {
            return parent::$method(...$params);
        };

        $closure->bindTo($clone)();

        return $clone;
    }
}
