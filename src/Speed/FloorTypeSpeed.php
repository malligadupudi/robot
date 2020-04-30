<?php
/**
 * Created by PhpStorm.
 * User: sykoral
 * Date: 09.08.2019
 * Time: 23:37
 */

namespace App\Speed;


/**
 * Speed of hoovering based on floor type.
 */
class FloorTypeSpeed {

    /**
     * @var float
     */
    private $cleaningSpeed;

    /**
     * @param double $cleaningSpeed
     */
    public function __construct(float $cleaningSpeed) {
        $this->cleaningSpeed = $cleaningSpeed;
    }

    /**
     * The area that can be cleaned in time.
     *
     * @param float $seconds
     *
     * @return float
     */
    public function getAreaForTime(float $seconds): float {
        return $seconds * $this->cleaningSpeed;
    }

    /**
     * The time that is needed for cleaning the area.
     *
     * @param float $metersSquaredArea
     *
     * @return float
     */
    public function getTimeForArea(float $metersSquaredArea): float {
        return $metersSquaredArea / $this->cleaningSpeed;
    }

}