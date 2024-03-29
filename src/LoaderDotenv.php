<?php

declare(strict_types=1);

namespace Stock2Shop\Environment;

use Dotenv\Dotenv;

class LoaderDotenv implements LoaderInterface
{
    public function __construct(
        private readonly string $env_path,
        private readonly string|array|null $names = null
    ) {
    }

    public function set(): void
    {
        $dotenv = Dotenv::createMutable($this->env_path, $this->names);
        $dotenv->load();
    }
}
