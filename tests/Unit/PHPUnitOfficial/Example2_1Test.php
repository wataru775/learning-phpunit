<?php


namespace Tests\Unit\org\mmpp\learning\phpunit\PHPUnitOfficial;

use PHPUnit\Framework\TestCase;

/**
 * PHPUnitマニュアル Example 2.1 PHPUnit での配列操作のテスト
 * Class Example2_1Test
 * @package Tests\Unit\org\mmpp\learning\phpunit\PHPUnitOfficial
 * @see https://phpunit.readthedocs.io/ja/latest/writing-tests-for-phpunit.html#writing-tests-for-phpunit-examples-stacktest-php
 */
class Example2_1Test extends TestCase
{
    public function testPushAndPop()
    {
        $stack = [];
        $this->assertSame(0, count($stack));

        array_push($stack, 'foo');
        $this->assertSame('foo', $stack[count($stack)-1]);
        $this->assertSame(1, count($stack));

        $this->assertSame('foo', array_pop($stack));
        $this->assertSame(0, count($stack));
    }

}