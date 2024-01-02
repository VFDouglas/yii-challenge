<?php

namespace tests\unit\models;

use app\models\Book;
use Codeception\Test\Unit;

class LoginFormTest extends Unit
{
    private $model;

    public function testBookData()
    {
        verify(Book::find()->all())->notEmpty();
    }
}
