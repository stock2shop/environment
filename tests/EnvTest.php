<?php

declare(strict_types=1);

namespace Stock2Shop\Tests\Environment;

use InvalidArgumentException;
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
            'Y' => '',
            'Z' => 'Bar'
        ]);
        Env::set($loader);
        $this->assertEquals('FOO', $_SERVER['X']);
        $this->assertEquals('', $_SERVER['Y']);
        $this->assertEquals('Bar', $_SERVER['Z']);
    }

    /**
     * @dataProvider nonStringDataProvider
     *
     * Throws InvalidArgumentException if non string value given
     */
    public function testSetByArrayNonString(array $env)
    {
        $this->expectException(InvalidArgumentException::class);
        $loader = new LoaderArray($env);
        Env::set($loader);
    }

    public function testGetByArray()
    {
        $loader = new LoaderArray([
            'X' => 'FOO'
        ]);
        Env::set($loader);
        $this->assertEquals('FOO', Env::get('X'));
        $this->assertEmpty(Env::get('Y'));
    }

    public function testMissingKeys()
    {
        $loader = new LoaderArray([
            'X' => 'FOO',
            'Y' => '',
            'Z' => 'Bar'
        ]);
        Env::set($loader);
        $missing = Env::missing(['W', 'X', 'Y', 'Z']);
        $this->assertCount(2, $missing);
        $this->assertTrue(in_array('W', $missing));
        $this->assertTrue(in_array('Y', $missing));
    }

    /**
     * @dataProvider truthyDataProvider
     */
    public function testIsTrue(array $env)
    {
        $loader = new LoaderArray($env);
        Env::set($loader);
        $this->assertTrue(Env::isTrue(key($env)));
    }

    /**
     * @dataProvider truthyDataProvider
     */
    public function testIsTrueDotEnv(array $env)
    {
        $loader = new LoaderDotenv(__DIR__, 'truthyTest.env');
        Env::set($loader);
        $this->assertTrue(Env::isTrue(key($env)));
    }

    /**
     * @dataProvider falsyDataProvider
     */
    public function testIsFalse(array $env)
    {
        $loader = new LoaderArray($env);
        Env::set($loader);
        $this->assertFalse(Env::isTrue(key($env)));
    }

    /**
     * @dataProvider falsyDataProvider
     */
    public function testIsFalseDotEnv(array $env)
    {
        $loader = new LoaderDotenv(__DIR__, 'falsyTest.env');
        Env::set($loader);
        $this->assertFalse(Env::isTrue(key($env)));
    }

    public function truthyDataProvider(): array
    {
        return [
            [['NUMERIC_BOOL' => '1']],
            [['STRING_BOOL' => 'True']],
            [['STRING_BOOL_WHITE_SPACE' => ' TrUe ']]
        ];
    }

    public function falsyDataProvider(): array
    {
        return [
            [['NUMERIC_BOOL' => '0']],
            [['STRING_BOOL' => 'false']],
            [['STRING_BOOL_WHITE_SPACE' => ' FalSe ']],
            [['STRING_FOO' => 'foo']]
        ];
    }

    public function nonStringDataProvider(): array
    {
        return [
            [['BOOL' => true]],
            [['BOOL_FALSE' => false]],
            [['INT' => 12]],
            [['FLOAT' => 123.2]],
            [['OBJECT' => new \stdClass()]],
            [['ARRAY' => []]]
        ];
    }
}
