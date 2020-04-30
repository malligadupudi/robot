<?php
/**
 * @author Malli
 * @copyright 2020 Valuelabs
 */
namespace Tests\Power;


use App\Power\BatteryPower;
use PHPUnit\Framework\TestCase;
use Exception;

class BatteryPowerTest extends TestCase {

    /**
     * Test battery capacity.
     *
     * @dataProvider getTestWorkProvider
     * @param float $minutesPower 
     * @param float $workTime
     * @param float $expectedMinutesCapacity
     *
     * @throws \Exception
     */
    public function testWork(float $minutesPower, float $workTime, float $expectedMinutesCapacity) {
        $batteryPower = new BatteryPower($minutesPower, 0);
        $batteryPower->work($workTime);
        $minutesCapacity = $batteryPower->getMaxWorkingTime();
        $this->assertSame($expectedMinutesCapacity, $minutesCapacity);
    }

    /**
     * input data for testWork.
     *
     * @return array
     */
    public function getTestWorkProvider(): array {
        return [
            "Half battery after work" => [60.0, 30.0, 30.0],
            "Empty battery after work" => [60.0, 60.0, 0.0],
        ];
    }

    /**
     * Test charging
     *
     * @dataProvider getTestChargeProvider
     *
     * @param $minutesPower
     * @param $workTime
     * @param $minutesCharge
     * @param $expectedMinutesCharge
     *
     * @throws \Exception
     */
    public function testCharge(float $minutesPower, float $workTime, float $minutesCharge, float $expectedMinutesCharge) {
        $batteryPower = new BatteryPower($minutesPower, $minutesCharge);
        $batteryPower->work($workTime);
        $minutesCharge = $batteryPower->charge();
        $this->assertSame($expectedMinutesCharge, $minutesCharge);
    }

    /**
     * Provides data for testCharge.
     *
     * @return array
     */
    public function getTestChargeProvider(): array {
        return [
            "Half battery after work" => [60.0, 30.0, 30.0, 15.0],
            "Empty battery after work" => [60.0, 60.0, 30.0, 30.0],
            "Full battery after work" => [60.0, 0.0, 30.0, 0.0],
        ];
    }

    /**
     * Work more than the capacity of battery.
     *
     * @throws \Exception
     */
    public function testWorkMoreThanCapacity() {
        $batteryPower = new BatteryPower(60, 30);
        $this->expectException(Exception::class);
        $batteryPower->work(61);
    }
}