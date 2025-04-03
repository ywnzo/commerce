var productRows = document.querySelectorAll(".product-row");
var searchInput = document.querySelector("#search-input");

function search() {
  var value = searchInput.value.toLowerCase();
  productRows.forEach(row => {
    if(value === '') {
      row.style.display = 'table-row';
    }
    var id = row.querySelector('.id-cell').innerHTML.toLowerCase();
    var name = row.querySelector('.name-cell').innerHTML.toLowerCase();

    if(!id.includes(value) && !name.includes(value)) {
      row.style.display = 'none';
    } else {
      row.style.display = 'table-row';
    }
  })
}

function main() {
  searchInput.addEventListener('keyup', search);
}

main();
