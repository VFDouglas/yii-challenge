'use strict';

if (window.$) {
    $.ajaxSetup({
        headers: {
            'Content-Type'    : 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
    });
}

let lastPageSearch = 1;

function showLoading(show = true) {
    document.activeElement.blur();
    if (show) {
        document.body.classList.add('pe-none');
        document.querySelector('.spinner').classList.remove('d-none');
    } else {
        document.body.classList.remove('pe-none');
        document.querySelector('.spinner').classList.add('d-none');
    }
}

async function showBooks(params = {}) {
    params.search = document.getElementById('search').value;
    showLoading(true);
    const jsonResponse = await getBooks(params);

    document.getElementById('div_books').innerHTML = '';
    if (jsonResponse.data.length > 0) {
        let html = '';
        for (const item of jsonResponse.data) {
            let textAppend = '';
            if (item?.description.length > 50) {
                textAppend = '...';
            }
            html += `
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 my-2">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <span class="text-truncate" data-bs-toggle="tooltip" title="${item.title}">
                                ${item.title}
                            </span>
                            <div class="d-flex">
                                <button class="btn" onclick="editBook(${item.id})" data-bs-toggle="tooltip"
                                        title="Edit Book">
                                    <i class="fa-solid fa-edit text-secondary"></i>
                                </button>
                                <button class="btn" onclick="deleteBook(${item.id})"
                                        data-bs-toggle="tooltip" title="Delete Book">
                                    <i class="fa-solid fa-trash text-danger"></i>
                                </button>
                            </div> 
                        </div>
                        <div class="card-body book_description">
                            <span data-bs-toggle="tooltip" data-bs-html="true"
                                  title="${item.description.replace('"', '&quot;')}">
                                ${item?.description.substring(0, 50) + textAppend}
                            </span>
                        </div>
                    </div>
                </div>
            `;
        }
        document.getElementById('div_books').innerHTML = html;
    } else {
        document.getElementById('div_books').innerHTML = `
            <div class="text-center position-absolute top-25">
                <img class="img-fluid" id="img_no_book_found" width="20" src="/images/books.png"
                     alt="Book image representing no books found">
                <div class="col-12 text-center text-black-50">
                    <h5>The registered books will appear here</h5>
                </div>
            </div>
        `;
    }
    showLoading(false);
    refreshTooltips();
    pagination({
        page     : params.page,
        recordQtt: jsonResponse.metadata.total,
        max      : jsonResponse.metadata.limit,
        qttPages : 5,
        id       : 'pagination',
        callback : 'showBooks',
    });
    lastPageSearch = params.page;
}

async function getBooks(params = {}) {
    let options       = {
        method: 'GET',
    };
    const paramsQuery = new URLSearchParams(params);
    const response    = await fetch(`/books/get?${paramsQuery.toString()}`, options);
    return await response.json();
}

showBooks().then();

async function editBook(id) {
    document.getElementById('request_method').value = 'PUT';
    document.getElementById('book_id').value        = id;

    showLoading(true);

    const jsonResponse = await getBooks({id});

    document.getElementById('book_id').value           = jsonResponse.data[0].id;
    document.getElementById('edit_title').value        = jsonResponse.data[0].title;
    document.getElementById('edit_description').value  = jsonResponse.data[0].description;
    document.getElementById('edit_author').value       = jsonResponse.data[0].author;
    document.getElementById('edit_pages_number').value = jsonResponse.data[0].pages_number;

    bootstrap.Modal.getOrCreateInstance('#modal_edit_book').show();
    showLoading(false);
}

function deleteBook(id) {
    showLoading(true);

    let options = {
        method : 'DELETE',
        headers: AJAX_HEADERS,
        body   : JSON.stringify({
            _csrf: yii.getCsrfToken(),
        }),
    };

    fetch(`/books/delete/${id}`, options).then(function (response) {
        if (!response.ok) {
            alert('Error retrieving data from the server');
            showLoading(false);
            return false;
        }
        response.json().then(function (jsonResponse) {
            showLoading(false);
            if (!jsonResponse.error) {
                showBooks();
            } else {
                alert('Error deleting the book');
            }
        });
    });
}

/**
 * Organize the records in pages
 * @param {number} params.page Page to be shown
 * @param {number} params.recordQtt Quantity of records to be paginated
 * @param {number} params.max Amount of items to be shown
 * @param {number} params.qttPages Amount of page itens
 * @param {string} params.id Pagination element ID
 * @param {string} params.callback Function to be bound to the pagination buttons
 */
function pagination(params = {}) {
    if (!params.qttPages) {
        params.qttPages = 5;
    }
    if (!params.page) {
        params.page = 1;
    }
    if (params.recordQtt > params.max) {
        document.getElementById(params.id).classList.remove('d-none');

        let pgs   = Math.ceil(params.recordQtt / params.max);
        let first = Math.ceil(params.page - params.qttPages / 2);

        if (first <= 0 && first < params.qttPages) {
            first = 1;
        }

        let ult = first + params.qttPages - 1;

        if (ult > pgs) {
            ult = pgs;
        }

        let previous   = params.page - 1;
        let next       = params.page + 1;
        let pagination = '';

        if (pgs > 1 && params.id) {
            if (previous > 0) {
                pagination += `
                    <li class='page-item'>
                        <button type='button' class='page-link h-100' onclick='${params.callback}({page: 1})' 
                                aria-label='First' data-bs-toggle="tooltip" title="First Page">
                            <i class='fa-solid fa-angle-double-left mt-1'></i>
                        </button>
                    </li>
                `;
                pagination += `
                    <li class='page-item'>
                        <button type='button' class='page-link h-100' data-bs-toggle="tooltip" title="Previous Page"
                                onclick='${params.callback}(" + anterior + ")' aria-label='Previous'>
                            <i class='fa-solid fa-angle-left mt-1'></i>
                        </button>
                    </li>
                `;
            } else {
                pagination += `
                    <li class='page-item'>
                        <button type='button' class='page-link h-100 disabled ' aria-label='Previous'>
                            <i class='fa-solid fa-angle-double-left mt-1'></i>
                        </button>
                    </li>
                `;
                pagination += `
                    <li class='page-item'>
                        <button type='button' class='page-link h-100 disabled' aria-label='Previous'>
                            <i class='fa-solid fa-angle-left mt-1'></i>
                        </button>
                    </li>
                `;
            }
            for (let i = first; i <= ult; i++) {
                if (i !== params.page) {
                    pagination += `
                        <li class='page-item'>
                            <button type='button' class='page-link h-100' onclick='${params.callback}({page: ${i}});'>
                                ${i}
                            </button>
                        </li>
                    `;
                } else {
                    pagination += `
                        <li class='page-item active'>
                            <button type='button' class='page-link h-100' id='pagina_atual'
                                    onclick='${params.callback}({page: ${i}});'>
                                ${i}
                            </button>
                        </li>
                    `;
                }
            }
            if (next <= pgs) {
                pagination += `
                    <li class='page-item'>
                        <button type='button' class='page-link h-100' onclick='${params.callback}({page: ${next}})'
                                aria-label='Next' data-bs-toggle="tooltip" title="Next Page">
                            <i class='fa-solid fa-angle-right mt-1'></i>
                        </button>
                    </li>
                `;
                pagination += `
                    <li class='page-item'>
                        <button type='button' class='page-link h-100' onclick='${params.callback}({page: ${pgs}})'
                                aria-label='Next' data-bs-toggle="tooltip" title="Last Page">
                            <i class='fa-solid fa-angle-double-right mt-1'></i>
                        </button>
                    </li>
                `;
            } else {
                pagination += `
                    <li class='page-item'>
                        <button type='button' class='page-link h-100 disabled' aria-label='Previous'>
                            <i class='fa-solid fa-angle-right mt-1'></i>
                        </button>
                    </li>
                `;
                pagination += `
                    <li class='page-item'>
                        <button type='button' class='page-link h-100 disabled' aria-label='Next'>
                            <i class='fa-solid fa-angle-double-right mt-1'></i>
                        </button>
                    </li>
                `;
            }
            document.getElementById(params.id).innerHTML = pagination;
        }
    } else {
        document.getElementById(params.id)?.classList.add('d-none');
    }
    refreshTooltips();
}

document.getElementById('btn_add_book').addEventListener('click', function () {
    document.getElementById('request_method').value = 'POST';
    document.getElementById('book_id').value        = '';
    document.getElementById('form_save_book').reset();

    bootstrap.Modal.getOrCreateInstance('#modal_edit_book').show();
});
document.getElementById('form_save_book')
    .addEventListener('submit', function (event) {
        event.preventDefault();

        let method  = document.getElementById('request_method')
            .value.toUpperCase();
        let options = {
            method : method,
            headers: AJAX_HEADERS,
            body   : JSON.stringify({
                _csrf       : yii.getCsrfToken(),
                title       : document.getElementById('edit_title').value,
                description : document.getElementById('edit_description').value,
                author      : document.getElementById('edit_author').value,
                pages_number: document.getElementById('edit_pages_number').value,
            }),
        };

        showLoading(true);

        let requestMethod;
        if (method === 'POST') {
            requestMethod = 'post';
        } else {
            requestMethod = `put/${document.getElementById('book_id').value}`;
        }
        fetch(`/books/${requestMethod}`, options).then(function (response) {
            if (!response.ok) {
                showLoading(false);
                alert('Error sending request');
                return false;
            }
            response.json().then(function (jsonResponse) {
                showLoading(false);
                if (!jsonResponse.error) {
                    showBooks({page: lastPageSearch});
                    bootstrap.Modal.getOrCreateInstance('#modal_edit_book')
                        .hide();
                } else {
                    alert(jsonResponse.error);
                }
            });
        });
        showLoading(true);
    });
document.getElementById('search_books').addEventListener('submit', function (event) {
    event.preventDefault();

    showBooks();
});