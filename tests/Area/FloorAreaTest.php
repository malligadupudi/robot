<?php
/**
 * @author Malli
 * @copyright 2020 Valuelabs
 */

namespace Area;

use PHPUnit\Framework\TestCase;
use App\Area\FloorArea;
use Exception;

class FloorAreaTest extends TestCase {

    /**
     * Test for cleaning.
     *
     * @dataProvider getCleaningProvider
     * @param float $metersSquaredArea 
     * @param float $clean  
     * @param float $expectedMaxCleaningArea 
     *
     * @throws \Exception
     */
    public function testClean(float $metersSquaredArea, float $clean, float $expectedMaxCleaningArea, bool $expectedIsCleaned) {
        $floorArea = new FloorArea($metersSquaredArea);
        $floorArea->clean($clean);
        $maxCleaningArea = $floorArea->getMaxCleaningArea();
        $isCleaned = $floorArea->isCleaned();
        $this->assertSame($expectedMaxCleaningArea, $maxCleaningArea);
        $this->assertSame($expectedIsCleaned, $isCleaned);
    }

    /**
     * Input data for testClean.
     *
     * @return array
     */
    public function getCleaningProvider(): array {
        return [
            "Basic subtraction" => [70.0, 30.0, 40.0, false],
            "Clean whole area" => [30.0, 30.0, 0.0, true],
            "Zero area" => [0.0, 0.0, 0.0, true],
            "Float subtraction" => [0.8, 0.1, 0.7, false],
        ];
    }

    /**
     * Clean more than the area.
     *
     * @throws \Exception
     */
    public function testCleanMoreThanPossible() {
        $floorArea = new FloorArea(10);
        $this->expectException(Exception::class);
        $floorArea->clean(20);
    }
}