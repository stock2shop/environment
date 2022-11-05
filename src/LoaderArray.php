<?php

declare(strict_types=1);

namespace Stock2Shop\Environment;

class LoaderArray implements LoaderInterface
{
    /**
     * @param array<string, string> $array
     */
    public function __construct(private readonly array $array)
    {
    }

    public function set(): void
    {
        foreach ($this->array as $k => $v) {
            if (!is_string($k) || !is_string($v)) {
                throw new \InvalidArgumentException('key and value must be strings');
            }
            $_SERVER[$k] = $v;
        }
    }
}
