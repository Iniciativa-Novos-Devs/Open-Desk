<?php

namespace Tests\Feature;

use Tests\TestCase;

class ReorderPositionTest extends TestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function testReorderHelperUpOne()
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

        $finalArray = \App\Libs\Helpers\ArrayHandler::reorder($original, $target, -1);

        $this->assertEquals($expected, $finalArray);
    }

    /**
     * @test
     *
     * @return void
     */
    public function testReorderHelperDownOne()
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

        $finalArray = \App\Libs\Helpers\ArrayHandler::reorder($original, $target, 1);

        $this->assertEquals($expected, $finalArray);
    }

    /**
     * @test
     *
     * @return void
     */
    public function testReorderHelperDownTwo()
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

        $finalArray = \App\Libs\Helpers\ArrayHandler::reorder($original, $target, 2);

        $this->assertEquals($expected, $finalArray);
    }
}
