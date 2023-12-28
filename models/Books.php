<?php

namespace app\models;

use yii\db\ActiveRecord;

class Books extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'books';
    }
}