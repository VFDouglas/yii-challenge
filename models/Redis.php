<?php

namespace app\Models;

use Predis\Client;
use yii\base\Model;

class Redis extends Model
{
    public Client $client;
    private const REDIS_CONTAINER = 'yii-challenge-redis-1';

    public function __construct()
    {
        parent::__construct();
        $this->client = new Client([
            'scheme' => 'tcp',
            'host'   => self::REDIS_CONTAINER,
            'port'   => 6379,
        ]);
    }
}
