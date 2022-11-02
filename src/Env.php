<?php

declare(strict_types=1);

namespace Stock2Shop\Environment;

class Env
{
    /**
     * Set Environment Variables
     */
    public static function set(LoaderInterface $loader): void
    {
        $loader->set();
    }

    /**
     * Fetches Environment Variable
     */
    public static function get(string $key): string|false
    {
        if (
            isset($_SERVER[$key]) &&
            is_string($_SERVER[$key]) &&
            $_SERVER[$key] !== ''
        ) {
            return $_SERVER[$key];
        }
        return false;
    }

    /**
     * @param string[] $keys
     * @return string[] name of missing key
     */
    public static function missing(array $keys): array
    {
        $missing = [];
        foreach ($keys as $key) {
            if (
                !isset($_SERVER[$key]) ||
                $_SERVER[$key] === ''
            ) {
                $missing[] = $key;
            }
        }
        return $missing;
    }
}
