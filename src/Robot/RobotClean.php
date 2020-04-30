<?php
/**
 * @author Malli
 * @copyright 2020 Valuelabs
 */

namespace App\Robot;

use App\Area\FloorArea;
use App\Speed\FloorTypeSpeed;
use App\Power\BatteryPower;

/**
 * All pieces of robot together.
 */
class RobotClean {

    /**
     * @var Array
     */
    const FLOOR_TYPES = ['hard' => 1, 'carpet' => 0.5];

    /**
     * @var integer
     */
    const POWER_TIME = 60;

    /**
     * @var integer
     */
    const CHARGE_TIME = 30;

    /**
     * @var FloorArea
     */
    private $floorArea;

    /**
     * @var FloorTypeSpeed
     */
    private $floorTypeSpeed;

    /**
     * @var BatteryPower
     */
    private $batteryPower;

    /**
     * @param string $floorType
     * @param float $area
     */
    public function __construct(string $floorType, float $area) {
        $this->floorArea = new FloorArea($area);
        $this->floorTypeSpeed = new FloorTypeSpeed($this::FLOOR_TYPES[$floorType]);
        $this->batteryPower = new BatteryPower($this::POWER_TIME, $this::CHARGE_TIME);
    }

    /**
     * Clening logic
     *
     * @return array
     * @throws \Exception
     */
    public function run(): array {
        $tasks = [];
        $i = 0;
        while (TRUE) {
            $i++;
            [
                $area,
                $cleaningTime,
            ] = $this->getCleaningAreaTime();

            //clean and Dischange
            $this->floorArea->clean($area);
            $this->batteryPower->work($cleaningTime);
            $tasks[ $i." Cleaning time"] = $cleaningTime;
            //Charge
            $timeToCharge = $this->batteryPower->charge();
            $tasks[$i. " Charging time"] = $timeToCharge;
            if ($this->floorArea->isCleaned()) {
                break;
            }
        }
        return $tasks;
    }

    /**
     * Find the size of area and time that can be used for cleaning.
     *
     * @return array
     */
    private function getCleaningAreaTime() {
        $maxWorkingTime = $this->batteryPower->getMaxWorkingTime();
        $maxCleaningArea = $this->floorArea->getMaxCleaningArea();
        $areaToCleanInMaxTime = $this->floorTypeSpeed->getAreaForTime($maxWorkingTime);
        $maxCleaningAreaTime = $this->floorTypeSpeed->getTimeForArea($maxCleaningArea);
        $minArea = min($areaToCleanInMaxTime, $maxCleaningArea);
        $minCleaningTime = min($maxWorkingTime, $maxCleaningAreaTime);
        return [$minArea, $minCleaningTime];
    }

}