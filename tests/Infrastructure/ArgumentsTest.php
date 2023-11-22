<?php

namespace Root\Skorikov\Infrastructure\Tests;

use PHPUnit\Framework\TestCase;
use Root\Skorikov\Exceptions\ArgumentsException;
use Root\Skorikov\Infrastructure\Arguments;

final class ArgumentsTest extends TestCase
{
    public static function argumentsProvider(): iterable
    {
        return [
            ['test1', 'test1'],
            [' test2', 'test2'],
            [' test3 ', 'test3'],
            [1, '1'],
            [123.21, '123.21'],
        ];
    }

    public function testItReturnsArgumentsValueByName(): void
    {
        $arguments = new Arguments(['test_key' => '1']);
        $value = $arguments->get('test_key');
        $this->assertSame('1', $value);
    }

    public function testItThrowsExceptionOnAbsentArgument(): void
    {
        $arguments = new Arguments([]);
        $this->expectException(ArgumentsException::class);
        $this->expectExceptionMessage("No such argument: test_key");
        $value = $arguments->get('test_key');
    }

    /**
     * @dataProvider argumentsProvider
     */
    public function testItConvertArgsToString($input, $expected): void
    {
        $arguments = new Arguments(['test_key' => $input]);
        $value = $arguments->get('test_key');
        $this->assertSame($expected, $value);
    }

    public function testItNotPassEmptyArgs(): void
    {
        $arguments = new Arguments([
            'test_key' => '1',
            'empty_arg' => '  '
        ]);
        $this->assertEquals($arguments, new Arguments([
            'test_key' => '1'
        ]));
    }

    public function testFromArgv(): void
    {
        $arguments = Arguments::fromArgv(['test_key1=1', 'test_key2=2']);
        $this->assertEquals($arguments, new Arguments([
            'test_key1' => '1',
            'test_key2' => '2'
        ]));
    }

    public function testFromArgvSkipsTooManyParts(): void
    {
        $arguments = Arguments::fromArgv([
            'test_key1=1', 
            'test_key2=2=skip',
            'test_key3=3'
        ]);
        $this->assertEquals($arguments, new Arguments([
            'test_key1' => '1',
            'test_key3' => '3'
        ]));
    }
}