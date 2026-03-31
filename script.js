const bar = document.getElementById('bar');
const close = document.getElementById('close');
const nav = document.getElementById('navbar');

if (bar) {
    bar.addEventListener('click', () => {
        nav.classList.add('active');
    })
}

if (close) {
    close.addEventListener('click', () => {
        nav.classList.add('active');
    })
}

function searchProducts() {
    const query = document.getElementById('searchBar').value;
    if (query.length > 0) {
        fetch(`search.php?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                const resultsContainer = document.getElementById('searchResults');
                resultsContainer.innerHTML = ''; // Clear previous results

                if (data.length > 0) {
                    data.forEach(product => {
                        const resultItem = document.createElement('div');
                        resultItem.className = 'result-item';
                        resultItem.innerHTML = `<a href="product.php?id=${product.id}">${product.name}</a>`;
                        resultsContainer.appendChild(resultItem);
                    });
                } else {
                    resultsContainer.innerHTML = '<p>No matching products found</p>';
                }
            })
            .catch(error => console.error('Error fetching search results:', error));
    } else {
        document.getElementById('searchResults').innerHTML = ''; // Clear results if query is empty
    }
}


