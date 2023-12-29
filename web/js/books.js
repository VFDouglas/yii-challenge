'use strict';

function getBooks(id = null) {
    let options = {
        method: 'GET',
    };

    const params = new URLSearchParams({
        id: id ?? '',
    });

    fetch(`./get?${params.toString()}`, options).then(function(response) {
        if (!response.ok) {
            return false;
        }
        response.json().then(function(retorno) {
            document.getElementById('div_books').innerHTML = '';
            if (retorno) {
                if (retorno.length > 0) {
                    let html = '';
                    for (const item of retorno) {
                        html += `
                            <div class="col-3 my-2">
                                <div class="card">
                                    <div class="card-header">
                                        ${item.title}
                                    </div>
                                    <div class="card-body">
                                        ${item.description}
                                    </div>
                                </div>
                                <span class="remove_book" onclick="removeBook(${item.id})">Remove book</span>
                            </div>
                        `;
                    }
                    document.getElementById('div_books').innerHTML = html;
                }
                else {
                    document.getElementById('div_books').innerHTML = `
                        <div class="col-12 text-center"><h5>No book found</h5></div>
                    `;
                }
            }
            else {
                alert('No books found.');
            }
        });
    });
}

getBooks();

function removeBook(id) {
    let options = {
        method: 'DELETE',
        body  : JSON.stringify({
            id: id,
        }),
    };

    fetch(`./removeBook`, options).then(function(response) {
        if (!response.ok) {
            alert('Error retrieving data from the server');
            return false;
        }
        response.json().then(function(retorno) {
            if (retorno) {
                if (retorno.query) {
                    getBooks();
                }
                else {
                    alert('Error removing the book');
                }
            }
            else {
                alert('Error retrieving data from the query');
            }
        });
    });
}