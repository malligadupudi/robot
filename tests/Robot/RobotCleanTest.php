<?php
/**
 * @author Malli
 * @copyright 2020 Valuelabs
 */

namespace Tests\Robot;


use App\Robot\RobotClean;
use PHPUnit\Framework\TestCase;

class RobotCleanTest extends TestCase{

    /**
     * @dataProvider getTestHooverProvider
     *
     * @param $floorType
     * @param $area
     *
     * @param $expectedTasks
     *
     * @throws \Exception
     */
    public function testHoover(string $floorType, float $area, array $expectedTasks){
         $cleanrRobot = new RobotClean($floorType, $area);
         $tasks = $cleanrRobot->run();
         $this->assertSame($tasks, $expectedTasks);
     }

    /**
     * Provides data for testHoover.
     *
     * @return array
     */
    public function getTestHooverProvider(): array {
        return [
            "hard" => ["hard", 60.0, ["hoovering_1" => 60.0, "charging_1" => 30.0]],
            "carpet" => ["carpet", 30.0, ["hoovering_1" => 60.0, "charging_1" => 30.0]]
        ];
    }
}
