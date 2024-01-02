<?php

$host = 'yii-challenge_mysql_1';

return [
    'class'    => 'yii\db\Connection',
    'dsn'      => "mysql:host=$host;port=3306;dbname=yii2basic",
    'username' => 'root',
    'password' => 'root',
    'charset'  => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
