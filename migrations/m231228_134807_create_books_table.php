<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `{{%books}}`.
 */
class m231228_134807_create_books_table extends Migration
{
    public const TABLE = 'books';

    public function up(): void
    {
        $this->createTable(self::TABLE, [
            'id'      => $this->primaryKey(),
            'title'   => $this->string()->notNull(),
            'content' => $this->text(),
        ]);
    }

    public function down(): void
    {
        $this->dropTable(self::TABLE);
    }
}
