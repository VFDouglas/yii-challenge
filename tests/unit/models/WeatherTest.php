<?php

namespace tests\unit\models;

use app\models\Weather;
use Codeception\Test\Unit;

class LoginFormTest extends Unit
{
    private $model;

    public function testWeatherData()
    {
        verify(Weather::getWeather(['Brasilia']))->notEmpty();
    }
}
