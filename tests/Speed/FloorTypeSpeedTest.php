<?php
/**
 * @author Malli
 * @copyright 2020 Valuelabs
 */

namespace Tests\Speed;


use App\Speed\FloorTypeSpeed;
use PHPUnit\Framework\TestCase;

class FloorTypeSpeedTest extends TestCase {

    /**
     * Test counting hoovering area from hoovering time.
     *
     * @dataProvider getAreaForTimeProvider
     *
     * @param $cleaningSpeed
     * @param $time
     * @param $expectedArea
     */
    public function testGetAreaForTime(float $cleaningSpeed, float $time, float$expectedArea) {
        $floorTypeSpeed = new FloorTypeSpeed($cleaningSpeed);
        $area = $floorTypeSpeed->getAreaForTime($time);
        $this->assertSame($expectedArea, $area);
    }

    /**
     * Provides data for testGetTimeForArea.
     *
     * @return array
     */
    public function getAreaForTimeProvider(): array {
        return [
            "One meter per one second" => [1.0, 60.0, 60.0],
            "One meter per two seconds" => [0.5, 60.0, 30.0],
        ];
    }

    /**
     * Test counting hoovering time from hoovering area.
     *
     * @dataProvider getTimeForAreaProvider
     *
     * @param $cleaningSpeed
     * @param $area
     * @param $expectedTime
     */
    public function testGetTimeForArea(float $cleaningSpeed, float $area, float $expectedTime) {
        $floorTypeSpeed = new FloorTypeSpeed($cleaningSpeed);
        $time = $floorTypeSpeed->getTimeForArea($area);
        $this->assertSame($expectedTime, $time);
    }

    /**
     * Provides data for testGetAreaForTime.
     *
     * @return array
     */
    public function getTimeForAreaProvider(): array {
        return [
            "One meter per one second" => [1.0, 60.0, 60.0],
            "One meter per two seconds" => [0.5, 30.0, 60.0],
        ];
    }
}