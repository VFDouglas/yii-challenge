<?php

use yii\db\ActiveRecord;

/**
 * @var yii\web\View $this
 * @var array|ActiveRecord[] $books
 */

$this->title                   = 'Books';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/books.js', ['position' => yii\web\View::POS_END, 'defer' => true]);
?>
<div class="modal fade" id="modal_edit_book" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_save_book">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal_edit_bookLabel">Edit Book</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="request_method">
                    <input type="hidden" id="book_id">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="edit_title" placeholder="Don Quixote"
                                       maxlength="255">
                                <label for="edit_title">Title</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <textarea class="form-control" id="edit_description"
                                          placeholder="Book Description"></textarea>
                                <label for="edit_description">Description</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="edit_author"
                                       placeholder="Miguel de Cervantes" maxlength="50">
                                <label for="edit_author">Author</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="edit_pages_number" placeholder="243">
                                <label for="edit_author">Number of Pages</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row justify-content-end mt-4 gy-3">
    <div class="col-12 col-md">
        <nav>
            <ul class="pagination justify-content-center" id="pagination"></ul>
        </nav>
    </div>
    <div class="col-12 col-sm-6 col-md">
        <form id="search_books">
            <div class="input-group mb-3">
                <input type="search" class="form-control" id="search" placeholder="Title, description or author">
                <button class="btn btn-success">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </form>
    </div>
    <div class="col-12 col-sm-6 col-md col-lg-3 text-end">
        <button class="btn btn-primary col-12 px-4" id="btn_add_book">New Book</button>
    </div>
</div>
<div class="row justify-content-center mt-4" id="div_books"></div>
