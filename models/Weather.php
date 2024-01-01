<?php

namespace app\models;

use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class Weather extends Model
{
    private const WEATHER_API_KEY = 'c3aaf6334f7e418ea49155157240101';

    public static function getWeather(array $cities): array
    {
        $redis  = new Redis();

        $response = [];
        foreach ($cities as $city) {
            $queryParams = http_build_query([
                'key' => self::WEATHER_API_KEY,
                'q'   => $city,
            ]);
            $redisKey    = 'weather_' . $city;
            if (!$redis->client->get($redisKey)) {
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL            => "https://api.weatherapi.com/v1/forecast.json?" . $queryParams,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING       => '',
                    CURLOPT_MAXREDIRS      => 10,
                    CURLOPT_TIMEOUT        => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST  => 'GET',
                ]);

                $response['data'][$city] = json_decode(curl_exec($curl), true);
                curl_close($curl);

                $redis->client->set($redisKey, json_encode($response['data'][$city]));
                $redis->client->expireat($redisKey, time() + 60 * 60);
                $response['cache'] = false;
            } else {
                $response['data'][$city] = json_decode($redis->client->get('weather_' . $city), true);
                $response['cache']       = true;
            }
        }
        return $response;
    }
}
