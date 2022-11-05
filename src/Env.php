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
     * Fetches Environment Variable from $_SERVER.
     */
    public static function get(string $key): string
    {
        if (!isset($_SERVER[$key])) {
            return '';
        }
        return (string)$_SERVER[$key];
    }

    /**
     * @param string[] $keys
     * @return string[] missing keys
     */
    public static function missing(array $keys): array
    {
        $missing = [];
        foreach ($keys as $key) {
            $value = self::get($key);
            if ($value === '') {
                $missing[] = $key;
            }
        }
        return $missing;
    }

    /**
     * @param string $key
     * @return bool
     */
    public static function isTrue(string $key): bool
    {
        $value = self::get($key);
        $trim = trim(strtolower($value));
        return in_array($trim, ['1', 'true']);
    }
}
