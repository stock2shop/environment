<?php

declare(strict_types=1);

namespace Stock2Shop\Environment;

/**
 * Interface for setting Environment Variables
 */
interface LoaderInterface
{
    public function set(): void;

}
