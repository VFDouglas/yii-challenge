<?php

/** @var yii\web\View $this */

$this->title = 'Books';
?>
<script src="js/app.js" defer></script>
<div class="container">
    <div class="row justify-content-end">
        <div class="col-3">
            <a class="btn btn-primary" id="btn_add_book" href="/books">New Book</a>
        </div>
    </div>
    <div class="row justify-content-center" id="div_books"></div>
</div>
