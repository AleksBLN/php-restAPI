let id = null;

async function getData() {
	let res = await fetch('http://php-restAPI/books');
    let books = await res.json();
    document.querySelector('.table-body').innerHTML = '';
    books.forEach(book => {
        document.querySelector('.table-body').innerHTML += `
            <tr>
                <th>${book.name}</th>
                <th>${book.author}</th>
                <th>${book.year}</th>
                <th class="d-flex justify-content-end">
                    <button type="button" class="btn btn-primary btn-sm mr-1" onclick="selectBook('${book.id}', '${book.name}', '${book.author}', '${book.year}')">Edit</button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeBook(${book.id})">Delete</button>
                </th>
                
            </tr>
        `
    });
}
async function addBook() {
    const name = document.getElementById('name').value;
    const author = document.getElementById('author').value;
    const year = document.getElementById('year').value;

    let formData = new FormData();
    formData.append('name', name);
    formData.append('author', author);
    formData.append('year', year);

    let res = await fetch('http://php-restAPI/books', {
        method: 'POST',
        body: formData,
    });

    document.getElementById('name').value = '';
    document.getElementById('author').value = '';
    document.getElementById('year').value = '';

    const data = await res.json();

     if (data.status === true) {
        await getData();
     }
}
async function removeBook(id) {
    let res = await fetch(`http://php-restAPI/books/${id}`, {
        method: 'DELETE',
    });

    const data = await res.json();

    if (data.status === true) {
        await getData();
     }
}

function selectBook(ID, name, author, year) {
    id = ID;
    document.getElementById('name-edit').value = name;
    document.getElementById('author-edit').value = author;
    document.getElementById('year-edit').value = year;
}

async function editBook() {
    const name = document.getElementById('name-edit').value;
    const author = document.getElementById('author-edit').value;
    const year = document.getElementById('year-edit').value;

    const dataObject = {
        name: name,
        author: author,
        year: year
    };

    document.getElementById('name-edit').value = '';
    document.getElementById('author-edit').value = '';
    document.getElementById('year-edit').value = '';

    let res = await fetch(`http://php-restAPI/books/${id}`, {
        method: 'PATCH',
        body: JSON.stringify(dataObject)
    });

    const data = await res.json();

    if (data.status === true) {
        await getData();
     }
}
getData();

