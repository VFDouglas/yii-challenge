<?php

/** @var yii\web\View $this */

$this->title = 'Books';
$this->registerJsFile('@web/js/books.js', ['position' => yii\web\View::POS_END]);
?>
<div class="container">
    <div class="row justify-content-end">
        <div class="col-3">
            <a class="btn btn-primary" id="btn_add_book" href="/new_book">New Book</a>
        </div>
    </div>
    <div class="row justify-content-center" id="div_books"></div>
</div>
