<?php
$this->Title = 'Список товарів';
$minAmount = PHP_INT_MAX;
$maxAmount = 0;
foreach ($accessories as $item) {
    $totalAmount = $item->price;
    if ($totalAmount < $minAmount) {
        $minAmount = $totalAmount;
    }
    if ($totalAmount > $maxAmount) {
        $maxAmount = $totalAmount;
    }
}
?>
<head>
    <title><?php echo $this->Title; ?></title>
    <link rel="stylesheet" type="text/css" href="/css/productsView.css">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        .scrollable-filter {
            max-height: 150px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 5px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar" data-aos="fade-right">
            <div class="position-sticky">
                <h1 class="fw-light"><?php echo $category; ?></h1>
                <br>
                <div>
                    <?php echo $description; ?>
                </div>
                <br>
                <div class="filter-section">
                    <h3>Фільтри товарів</h3>
                    <div class="price-filter">
                        <label for="priceMin">Ціна (грн):</label>
                        <input type="number" id="priceMin" placeholder="50" value="50">
                        <span> - </span>
                        <input type="number" id="priceMax" placeholder="2100" value="2100">
                    </div>
                    <br>
                    <h4>Кольори:</h4>
                    <div class="form-group scrollable-filter">
                        <?php foreach ($colors as $color) : ?>
                        <div>
                            <input type="checkbox" id="<?= $color ?>" name="color[]" value="<?= $color ?>">
                            <label for="<?= $color ?>"><?= $color ?></label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <h4>Матеріали:</h4>
                    <div class="form-group scrollable-filter">
                        <?php foreach ($materials as $material) : ?>
                        <div>
                            <input type="checkbox" id="<?= $material ?>" name="material[]" value="<?= $material ?>">
                            <label for="<?= $material ?>"><?= $material ?></label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="btn btn-black mt-3" id="filterButton">Фільтрувати</button>
                </div>
            </div>
        </nav>
        <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 content">
            <div class="pagination-info mt-3">
                <a class="page-link" href="#" aria-label="Previous" id="prevPage">
                    <span aria-hidden="true">&laquo;</span>
                </a>
                <span>Page <span id="currentPageDisplay">1</span> of <span id="totalPagesDisplay">2</span></span>
                <a class="page-link" href="#" aria-label="Next" id="nextPage">
                    <span aria-hidden="true">&raquo;</span>
                </a>
                <form class="search-container" id="searchForm">
                    <div class="input-group">
                        <input type="search" class="form-control" placeholder="Search..." aria-label="Search" id="searchInput" name="search_query">
                        <button type="submit" class="btn btn-black" id="searchButton">Search</button>
                    </div>
                </form>
            </div>
            <div class="album py-5 bg-body-tertiary" data-aos="fade-left">
                <div class="container">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3" id="accessoryRow">
                        <!-- Товари будуть тут -->
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
        var minAmount = <?php echo $minAmount; ?>;
        var maxAmount = <?php echo $maxAmount; ?>;

        var accessories = <?php echo json_encode($accessories); ?>;
        var currentPage = 1;
        var itemsPerPage = 9;

        function renderAccessories() {
            var accessoryRow = document.getElementById('accessoryRow');
            accessoryRow.innerHTML = '';

            var start = (currentPage - 1) * itemsPerPage;
            var end = start + itemsPerPage;
            var paginatedItems = accessories.slice(start, end);

            paginatedItems.forEach(function(accessory) {
                var isInStock = accessory.quantity > 0 ? 'В НАЯВНОСТІ' : 'НЕ В НАЯВНОСТІ';
                var card = document.createElement('div');
                card.className = 'col';
                card.innerHTML = `
                    <div class="card shadow-sm">
                        <a href="/products/accessory/${accessory.id}">
                            <img src="${accessory.image}" class="bd-placeholder-img card-img-top" width="100%" height="260" aria-label="Placeholder: ${accessory.title}" preserveAspectRatio="xMidYMid slice" focusable="false">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">${accessory.title}</h5>
                            <p class="card-text">${accessory.short_description}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary buy-btn" data-accessory-id="${accessory.id}">Замовити</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary addToCart-btn" data-accessory-id="${accessory.id}">Додати до кошика</button>
                                </div>
                                <small class="text-muted">Price: ${accessory.price}$</small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <small class="text-${isInStock === 'В НАЯВНОСТІ' ? 'success' : 'danger'}">${isInStock}</small>
                            </div>
                        </div>
                    </div>
                `;
                accessoryRow.appendChild(card);
            });

            document.getElementById('currentPageDisplay').innerText = currentPage;
            document.getElementById('totalPagesDisplay').innerText = Math.ceil(accessories.length / itemsPerPage);

            bindEventHandlers();
        }

        function bindEventHandlers() {
            document.querySelectorAll('.buy-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var accessoryId = this.dataset.accessoryId;
                    window.location.href = `/products/order/${accessoryId}`;
                });
            }); 

            document.querySelectorAll('.addToCart-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var accessoryId = this.dataset.accessoryId;

                    fetch('/products/addToBasket', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ accessory_id: accessoryId })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        const basketItemCountElement = document.getElementById('basketItemCount');
                        const count = parseInt(basketItemCountElement.textContent); 
                        console.log(count);
                        if(!isNaN(count) && count !== null){
                            basketItemCountElement.textContent = count + 1;
                        }else{
                            basketItemCountElement.textContent = 1;
                        }

                        return response.json();
                    })
                    .then(data => {
                        console.log(data);
                    })
                    .catch(error => {
                        console.error('There was an error!', error);
                    });
                });
            });
        }

        document.getElementById('searchForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var query = document.getElementById('searchInput').value;
            var category = <?php echo json_encode($category); ?>;

            fetch('/products/searchAccessory', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ search_query: query, category: category })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                accessories = data.accessories;
                currentPage = 1;
                renderAccessories();
            })
            .catch(error => {
                console.error('There was an error!', error);
            });
        });

        document.getElementById('filterButton').addEventListener('click', function() {
            var minPrice = document.getElementById('priceMin').value;
            var maxPrice = document.getElementById('priceMax').value;

            var searchQuery = document.getElementById('searchInput').value;
            if (searchQuery.trim() === '') {
                searchQuery = null;
            }
            var selectedColors = Array.from(document.querySelectorAll('input[name="color[]"]:checked')).map(function(checkbox) {
                return checkbox.value;
            });

            var selectedMaterials = Array.from(document.querySelectorAll('input[name="material[]"]:checked')).map(function(checkbox) {
                return checkbox.value;
            });

            fetch('/products/searchAccessory', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ 
                     search_query: searchQuery,
                     priceMin: minPrice,
                     priceMax: maxPrice,
                     colors: selectedColors,
                     materials: selectedMaterials, 
                     category: <?php echo json_encode($category); ?>
                     })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                accessories = data.accessories;
                currentPage = 1;
                renderAccessories();
            })
            .catch(error => {
                console.error('There was an error!', error);
            });
        });

        document.getElementById('prevPage').addEventListener('click', function(event) {
            event.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                renderAccessories();
            }
        });

        document.getElementById('nextPage').addEventListener('click', function(event) {
            event.preventDefault();
            if (currentPage < Math.ceil(accessories.length / itemsPerPage)) {
                currentPage++;
                renderAccessories();
            }
        });

        renderAccessories();
        document.getElementById('priceMin').setAttribute('min', minAmount);
        document.getElementById('priceMin').setAttribute('max', maxAmount);
        document.getElementById('priceMax').setAttribute('min', minAmount);
        document.getElementById('priceMax').setAttribute('max', maxAmount);

        document.getElementById('priceMin').setAttribute('value', minAmount);
        document.getElementById('priceMax').setAttribute('value', maxAmount);
    </script>
</body>
