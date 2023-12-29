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
            'id'           => $this->primaryKey(),
            'title'        => $this->string()->notNull(),
            'description'  => $this->text()->notNull(),
            'author'       => $this->string(50)->notNull(),
            'pages_number' => $this->integer()->notNull(),
            'created_at'   => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP')
        ]);
        $this->insert(self::TABLE, [
            'title'        => 'The Hobbit',
            'description'  => 'The Hobbit is a novel by J. R. R. Tolkien.',
            'author'       => 'J. R. R. Tolkien',
            'pages_number' => 310,
        ]);
        $this->insert(self::TABLE, [
            'title'        => 'The Lord of the Rings',
            'description'  => 'The Lord of the Rings is a novel by J. R. R. Tolkien.',
            'author'       => 'J. R. R. Tolkien',
            'pages_number' => 440,
        ]);
        $this->insert(self::TABLE, [
            'title'        => 'The Two Towers',
            'description'  => 'The Two Towers is a novel by J. R. R. Tolkien.',
            'author'       => 'J. R. R. Tolkien',
            'pages_number' => 440,
        ]);
        $this->insert(self::TABLE, [
            'title'        => 'Don Quixote',
            'description'  => 'Don Quixote is a novel by Miguel de Cervantes.',
            'author'       => 'Miguel de Cervantes',
            'pages_number' => 1000,
        ]);
        $this->insert(self::TABLE, [
            'title'        => 'Moby Dick',
            'description'  => 'Moby Dick is a novel by Herman Melville.',
            'author'       => 'Herman Melville',
            'pages_number' => 650,
        ]);
        $this->insert(self::TABLE, [
            'title'        => 'War and Peace',
            'description'  => 'War and Peace is a novel by Leo Tolstoy.',
            'author'       => 'Leo Tolstoy',
            'pages_number' => 1000,
        ]);
        $this->insert(self::TABLE, [
            'title'        => 'The Catcher in the Rye',
            'description'  => 'The Catcher in the Rye is a novel by J. D. Salinger.',
            'author'       => 'J. D. Salinger',
            'pages_number' => 320,
        ]);
        $this->insert(self::TABLE, [
            'title'        => 'Brave New World',
            'description'  => 'Brave New World is a novel by Aldous Huxley.',
            'author'       => 'Aldous Huxley',
            'pages_number' => 320,
        ]);
        $this->insert(self::TABLE, [
            'title'        => 'Alice\'s Adventures in Wonderland',
            'description'  => 'Alice\'s Adventures in Wonderland is a novel by Lewis Carroll.',
            'author'       => 'Lewis Carroll',
            'pages_number' => 320,
        ]);
        $this->insert(self::TABLE, [
            'title'        => 'The Adventures of Huckleberry Finn',
            'description'  => 'The Adventures of Huckleberry Finn is a novel by Mark Twain.',
            'author'       => 'Mark Twain',
            'pages_number' => 320,
        ]);
    }

    public function down(): void
    {
        $this->dropTable(self::TABLE);
    }
}
