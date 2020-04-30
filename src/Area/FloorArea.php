<?php
/**
 * @author Malli
 * @copyright 2020 Valuelabs
 */

namespace App\Area;


use Exception;

/**
 * data that is cleaned area and not cleaned area
 */
class FloorArea {

    /**
     * @var float
     */
    private $metersSquaredArea;

    /**
     * @var float
     */
    private $metersSquaredCleaned;

    /**
     * @param double $metersSquaredArea
     */
    public function __construct(float $metersSquaredArea) {
        $this->metersSquaredArea = $metersSquaredArea;
        $this->metersSquaredCleaned = 0;
    }

    /**
     * The clean the part of the area.
     *
     * @param float $metersSquared
     *
     * @return float|int
     * @throws \Exception
     */
    public function clean(float $metersSquared): float {
        if ($metersSquared > $this->metersSquaredArea - $this->metersSquaredCleaned) {
            throw new Exception('Robot would like to clean more meters than it is possible.');
        }
        else {
            $this->metersSquaredCleaned += $metersSquared;
        }
        return $this->metersSquaredArea - $this->metersSquaredCleaned - $metersSquared;
    }

    /**
     * get Max Cleaning Area
     *
     * @return float
     */
    public function getMaxCleaningArea(): float {
        return $this->metersSquaredArea - $this->metersSquaredCleaned;
    }

    /**
     * check the area Cleaned or not
     *
     * @return bool
     */
    public function isCleaned(): bool {
        return $this->metersSquaredCleaned >= $this->metersSquaredArea;
    }
}