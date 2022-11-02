<?php

declare(strict_types=1);

namespace Stock2Shop\Tests\Environment;

use PHPUnit\Framework\TestCase;
use Stock2Shop\Environment\Env;
use Stock2Shop\Environment\LoaderDotenv;
use Stock2Shop\Environment\LoaderArray;

class EnvTest extends TestCase
{
    public function testSetByDotenv()
    {
        $_SERVER['X'] = 'x';
        $_SERVER['Y'] = 'y';
        $loader       = new LoaderDotenv(__DIR__, 'test.env');
        Env::set($loader);
        $this->assertEquals('FOO', $_SERVER['X']);
        $this->assertEquals('', $_SERVER['Y']);
        $this->assertEquals('Bar', $_SERVER['Z']);
    }

    public function testSetByArray()
    {
        $_SERVER['X'] = 'x';
        $_SERVER['Y'] = 'y';
        $loader       = new LoaderArray([
            'X' => 'FOO',
            'Y'   => '',
            'Z'   => 'Bar'

        ]);
        Env::set($loader);
        $this->assertEquals('FOO', $_SERVER['X']);
        $this->assertEquals('', $_SERVER['Y']);
        $this->assertEquals('Bar', $_SERVER['Z']);
    }

    public function testGetByArray()
    {
        $loader       = new LoaderArray([
            'X' => 'FOO'

        ]);
        Env::set($loader);
        $this->assertEquals('FOO', Env::get('X'));
        $this->assertFalse(Env::get('Y'));
    }

    public function testMissingKeys()
    {
        $loader       = new LoaderArray([
            'X' => 'FOO',
            'Y'   => '',
            'Z'   => 'Bar'
        ]);
        Env::set($loader);
        $missing = Env::missing(['W', 'X', 'Y', 'Z']);
        $this->assertCount(2, $missing);
        $this->assertTrue(in_array('W', $missing));
        $this->assertTrue(in_array('Y', $missing));
    }
}