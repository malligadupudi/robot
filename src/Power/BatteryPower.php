<?php
/**
 * @author Malli
 * @copyright 2020 Valuelabs
 */

namespace App\Power;

use Exception;

/**
 * battery Data.
 */
class BatteryPower {
    
    /**
     * @var float
     */
    private $minutesCharge;

    /**
     * @var float
     */
    private $minutesPower;

    /**
     * @var float
     */
    private $capacity;

    /**
     * @param float $minutesPower
     * @param float $minutesCharge
     */
    public function __construct(float $minutesPower, float $minutesCharge) {
        $this->minutesPower = $minutesPower;
        $this->minutesCharge = $minutesCharge;
        $this->capacity = 1;
    }

    /**
     * Battery capacity.
     *
     * @return float
     */
    public function getMaxWorkingTime(): float {
        return $this->minutesPower * $this->capacity;
    }

    /**
     * Charge the battery.
     *
     * @return float
     */
    public function charge(): float {
        $timeToCharge = $this->minutesCharge * (1 - $this->capacity);
        $this->capacity = 1;
        return $timeToCharge;
    }

    /**
     * Uses of the battery.
     *
     * @param float $seconds
     *
     * @throws \Exception
     */
    public function work(float $seconds) {
        if ($seconds <= $this->getMaxWorkingTime()) {
            $this->capacity = 1 - ($seconds / $this->minutesPower);
        }
        else {
            throw new Exception('Battery does not have capacity.');
        }
    }

}