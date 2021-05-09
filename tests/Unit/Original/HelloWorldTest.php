<?php


namespace Tests\Unit\org\mmpp\learning\phpunit\Original;

use org\mmpp\learning\phpunit\Original\HelloWorld;
use PHPUnit\Framework\TestCase;

/**
 * [オリジナル] ハロー・ワールドのクラスのテスト
 * Class HelloWorldTest
 * @package Tests\Unit\org\mmpp\learning\phpunit\Original
 */
class HelloWorldTest extends TestCase
{
    /**
     * ハローを返すだけのテスト
     */
    public function test_say(){
        $hello_world = new HelloWorld();
        $this->assertEquals('hello',$hello_world->say());
    }
}