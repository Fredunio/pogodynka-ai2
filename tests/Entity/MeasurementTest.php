<?php

namespace App\Tests\Entity;

use App\Entity\Measurement;
use PHPUnit\Framework\TestCase;

class MeasurementTest extends TestCase
{

    /**
     * @dataProvider dataGetFahrenheit
     */
    public function testGetFahrenheit($celsius, $expectedFahrenheit): void
    {
        $measurement = new Measurement();

        $measurement->setTemperature($celsius);
        $this->assertEquals($expectedFahrenheit, $measurement->getFahrenheit());

    }

    public function dataGetFahrenheit(): array
    {
        return [
            ['0', 32],
            ['-100', -148],
            ['100', 212],
            ['5.1', 41.18],
            ['49.5', 121.1],
            ['31.7', 89.06],
            ['21.9', 71.42],
            ['10.2', 50.36],
            ['1.1', 33.98],
            ['-10.2', 13.64],
        ];
    }
}
