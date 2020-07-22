async function getData() {
	let res = await fetch('http://php-restAPI/books');
    let books = await res.json();
    console.log(res);
    console.log(books);
    books.forEach(book => {
        document.querySelector('.post-list').innerHTML += `
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">${book.name}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">${book.author}</h6>
                    <p class="card-text">${book.year}</p>
                    <a href="#" class="card-link">Card link</a>
                    <a href="#" class="card-link">Another link</a>
                </div>
            </div>
        `      
    });
}
getData();