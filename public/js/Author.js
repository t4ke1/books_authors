function getJWTFromCookie() {
    const cookies = document.cookie.split(';');
    for (let cookie of cookies) {
        const [name, value] = cookie.trim().split('=');
        if (name === 'token') {
            return value;
        }
    }
    return null;
}
document.addEventListener('DOMContentLoaded', function() {
    let buttons = document.querySelectorAll('.list-group-item');

    buttons.forEach(function(button) {
        button.addEventListener('click', function() {
            var id = button.id;
            console.log(id);
            fetch(`/api/get-author/${id}`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${getJWTFromCookie()}`,
                    "Content-Type": "application/json"
                },
            })
                .then(response => {
                    if (!response.ok) {
                        switch (response.status) {
                            case 404:
                                alert('Not found');
                                break;
                            case 400:
                                alert('Bad request');
                                break;
                            case 401:
                                alert('Unauthorized, please login');
                                break;
                            default:
                                alert('Unknown error');
                                break;
                        }
                        throw new Error('Network response was not ok. ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    const author = data.author;
                    document.getElementById('authorId').value = author.id;
                    document.getElementById('authorName').value = author.name;
                    document.getElementById('bookCount').value = author.bookCount;
                    const bookList = document.getElementById('bookList');
                    bookList.innerHTML = '<label for="bookList" class="form-label">Список книг</label>';
                    author.books.forEach((book, index) => {
                        const bookInput = document.createElement('input');
                        bookInput.type = 'text';
                        bookInput.className = 'form-control mb-1';
                        bookInput.id = `bookList${index}`;
                        bookInput.placeholder = 'Название книги';
                        bookInput.value = book;
                        bookList.appendChild(bookInput);
                    });
                    var modal = new bootstrap.Modal(document.getElementById('exampleModal'));
                    modal.show();
                    console.log(author);
                    const updateButton = document.getElementById('update');
                    updateButton.addEventListener('click', function() {
                        document.getElementById('authorIdUpdate').value = author.id;
                        document.getElementById('authorNameUpdate').value = author.name;
                        document.getElementById('bookCountUpdate').value = author.bookCount;
                        console.log(author);
                        var modal = new bootstrap.Modal(document.getElementById('updateModal'));
                        modal.show();
                    });

                    const saveButton = document.getElementById('save');
                    saveButton.addEventListener('click', function() {
                        const authorIdUpdate = document.getElementById('authorIdUpdate').value;
                        const authorNameUpdate = document.getElementById('authorNameUpdate').value;

                        const changeBook = {
                            id: authorIdUpdate,
                            name: authorNameUpdate,
                        }
                        fetch(`/api/update-author`,
                            {
                                method: 'PUT',
                                headers: {
                                    'Authorization': `Bearer ${getJWTFromCookie()}`,
                                    "Content-Type": "application/json"
                                },
                                body: JSON.stringify(changeBook)
                            })
                            .then(response => {
                                if (response.ok) {
                                    alert('Author successfully updated');
                                    location.reload();
                                } else {
                                    switch (response.status) {
                                        case 404:
                                            alert('Not found');
                                            break;
                                        case 400:
                                            alert('Bad request');
                                            break;
                                        case 401:
                                            alert('Unauthorized, please login');
                                            break;
                                        default:
                                            alert('Unknown error');
                                            break;
                                    }
                                }
                            })
                        modal.hide();


                    });

                });
        });
    });
})

