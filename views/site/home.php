<?php

/**
 * @var yii\web\View $this
 * @var array $weather
 */

$this->title = 'Home';

$index           = 0;
$carouselButtons = '';
$carouselHtml    = '';
foreach ($weather['data'] as $key => $city) {
    $active          = $index == 0 ? 'active' : '';
    $carouselButtons .= <<<BUTTONS
        <button type="button" data-bs-target="#carousel_weather" data-bs-slide-to="$index" class="$active"
                aria-current="true" aria-label="Slide 1"></button>
    BUTTONS;

    $tempCelsius    = $city['current']['temp_c'] ?? 0;
    $tempFahrenheit = $city['current']['temp_f'] ?? 0;

    $lastUpdate   = date('l, H:i', strtotime($city['current']['last_updated']));
    $carouselHtml .= <<<CITY
        <div class="carousel-item $active px-sm-5 py-4">
            <div class="row mb-5 px-sm-5">
                <div class="col-12 col-sm-6 my-2 d-flex align-items-center justify-content-center">
                    <img src="{$city['current']['condition']['icon']}"
                         width="60" class="d-block img-fluid align-self-center align-self-sm-end" alt="..."
                         data-bs-toggle="tooltip" title="{$city['current']['condition']['text']}">
                    <div class="row temperature align-self-baseline mt-1 fw-semibold" data-type="C">
                        <div class="col temperature_number pe-0 text-nowrap align-self-end">
                            <span class="fs-1 pe-0 current_temperature"
                                data-temp-celsius="$tempCelsius"
                                data-temp-fahrenheit="$tempFahrenheit">$tempCelsius</span>
                            <span class="fs-5 ps-0 align-top">
                                <span class="temperature_types cursor-pointer" data-type="C">ºC</span> |
                                <span class="temperature_types cursor-pointer text-white-50" data-type="F">ºF</span>
                            </span>
                        </div>
                        <div class="col">
                            <span class="d-block">Rain:&nbsp;{$city['current']['precip_in']}&nbsp;%</span>
                            <span class="d-block">Humidity:&nbsp;{$city['current']['humidity']}&nbsp;%</span>
                            <span class="d-block">Wind:&nbsp;{$city['current']['wind_kph']}&nbsp;kph</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 my-2 text-center text-sm-end align-self-sm-center">
                    <h5>Weather</h5>
                    <h6>$lastUpdate</h6>
                    <span>{$city['current']['condition']['text']}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <h4 class="city">{$city['location']['name']}, {$city['location']['country']}</h4>
                </div>
            </div>
        </div>
    CITY;
    $index++;
}
$this->registerJsFile('@web/js/home.js', ['position' => yii\web\View::POS_END, 'defer' => true]);
?>
<div class="container-fluid position-relative top-20">
    <div class="row align-items-center">
        <div class="col-12 col-md-7 col-lg">
            <h4 class="text-black-50">Current weather on different cities</h4>
        </div>
        <div class="col-12 col-md-5 col-lg">
            <form id="search_books">
                <div class="input-group mb-3">
                    <input type="search" class="form-control" name="cities"
                           placeholder="Multiple cities separated by comma">
                    <button class="btn btn-success">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div id="carousel_weather" class="carousel slide bg-light-gray rounded py-5" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <?= $carouselButtons; ?>
            </div>
            <div class="carousel-inner">
                <?= $carouselHtml; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel_weather"
                    data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel_weather"
                    data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</div>
