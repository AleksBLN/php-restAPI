function sortTable(table, column, asc = true) {
    const directionMod = asc ? 1 : -1;
    const tBody = table.tBodies[0];
    const rows = Array.from(tBody.querySelectorAll('tr'));

    const sortedRows = rows.sort((a, b) => {
        const aColText = a.querySelector(`th:nth-child(${column + 1})`).textContent.trim();
        const bColText = b.querySelector(`th:nth-child(${column + 1})`).textContent.trim();
        return aColText > bColText ? (1 * directionMod) : (-1 * directionMod);
    });

    while (tBody.firstChild) {
        tBody.removeChild(tBody.firstChild);
    }

    tBody.append(...sortedRows);
    table.querySelectorAll('.sort').forEach(th => th.classList.remove('th-sort-asc', 'th-sort-desc'));
    table.querySelector(`.sort:nth-child(${column + 1})`).classList.toggle('th-sort-asc', asc);
    table.querySelector(`.sort:nth-child(${column + 1})`).classList.toggle('th-sort-desc', !asc);
}

document.querySelectorAll('.sort').forEach(headerCell => {
    headerCell.addEventListener('click', () => {
        const tableElement = headerCell.parentElement.parentElement.parentElement;
        const headerIndex = Array.prototype.indexOf.call(headerCell.parentElement.children, headerCell);
        const currentIsAscending = headerCell.classList.contains('th-sort-asc');

        sortTable(tableElement, headerIndex, !currentIsAscending);
    })
})


