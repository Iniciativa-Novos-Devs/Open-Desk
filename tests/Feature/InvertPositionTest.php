<?php

namespace Tests\Feature;

use Tests\TestCase;

class InvertPositionTest extends TestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function testInvertPositionHelperUpOne()
    {
        $original = [
            10 => 'a',
            20 => 'b',
        ];

        $expected = [
            10 => 'b',
            20 => 'a',
        ];

        $target = 20;

        $finalArray = \App\Libs\Helpers\ArrayHandler::invertPositionWith($original, $target, -1);

        $this->assertEquals($finalArray, $expected);
    }

    /**
     * @test
     *
     * @return void
     */
    public function testInvertPositionHelperDownOne()
    {
        $original = [
            10 => 'a',
            20 => 'b',
            30 => 'c',
            40 => 'd',
        ];

        $expected = [
            10 => 'a',
            20 => 'b',
            30 => 'd',
            40 => 'c',
        ];

        $target = 30;

        $finalArray = \App\Libs\Helpers\ArrayHandler::invertPositionWith($original, $target, +1);

        $this->assertEquals($finalArray, $expected);
    }

    /**
     * @test
     *
     * @return void
     */
    public function testInvertPositionHelperDownTwo()
    {
        $original = [
            10 => 'a',
            20 => 'b',
            30 => 'c',
            40 => 'd',
        ];

        $expected = [
            10 => 'a',
            20 => 'd',
            30 => 'c',
            40 => 'b',
        ];

        $target = 20;

        $finalArray = \App\Libs\Helpers\ArrayHandler::invertPositionWith($original, $target, 2);

        $this->assertEquals($finalArray, $expected);
    }

    /**
     * @test
     *
     * @return void
     */
    public function testInvertPositionHelperDownThree()
    {
        $original = [
            10 => 'a',
            20 => 'b',
            30 => 'c',
            40 => 'd',
        ];

        $expected = [
            10 => 'd',
            20 => 'b',
            30 => 'c',
            40 => 'a',
        ];

        $target = 10;

        $finalArray = \App\Libs\Helpers\ArrayHandler::invertPositionWith($original, $target, 3);

        $this->assertEquals($finalArray, $expected);
    }

    /**
     * @test
     *
     * @return void
     */
    public function testInvertPositionHelperInvalidPosition()
    {
        $original = [
            10 => 'a',
            20 => 'b',
            30 => 'c',
            40 => 'd',
        ];

        $target = 10;

        $finalArray = \App\Libs\Helpers\ArrayHandler::invertPositionWith($original, $target, -2);

        $this->assertEquals($finalArray, $original);
    }
}
