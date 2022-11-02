<?php

declare(strict_types=1);

namespace Stock2Shop\Environment;

class LoaderArray implements LoaderInterface
{

    public function __construct(private readonly array $array)
    {
    }

    public function set(): void
    {
        foreach ($this->array as $k => $v) {
            if (!is_string($k)) {
                continue;
            }
            $_SERVER[$k] = $v;
        }
    }

}
