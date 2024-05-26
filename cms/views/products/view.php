<?php

$this->Title = 'Список товарів';

?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $this->Title; ?></title>
    <style>
        .btn-black {
            background-color: black;
            color: white;
        }

        .card {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out, background-color 0.3s ease-in-out;
        }

        .card:hover {
        transform: translateY(-10px);
        background-color: #f5f5f5; 
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2); 
        }
       

        .btn-black:hover {
            background-color: #333;
        }

        .add-accessory-btn {
            margin-bottom: 20px;
        }

        .highlight {
            border: 2px solid yellow;
            background-color: #ffffe0;
        }
    </style>
</head>
<body>
    <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light"><?php echo $category; ?></h1>
                <br>
                <form class="w-100" id="searchForm">
                    <div class="input-group"> 
                        <input type="search" class="form-control" placeholder="Search..." aria-label="Search" id="searchInput" name="search_query">
                        <button type="submit" class="btn btn-black" id="searchButton">Search</button>
                    </div>
                </form>
                <br>
                <div>
                <?php echo $description; ?>
                </div>
                <br>
            </div>            
        </div>
    </section>
    <div class="album py-5 bg-body-tertiary">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3" id="accessoryRow">
                <!-- Туть будуть аксесуари -->
            </div>
        </div>
    </div>
    <script>
    var accessories = <?php echo json_encode($accessories); ?>;
    accessories.forEach(function(accessory) {
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
                    </div>
                </div>
            `;
            document.getElementById('accessoryRow').appendChild(card);
        });


        document.querySelectorAll('.buy-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var accessoryId = this.dataset.accessoryId;
            window.location.href = `buy/${accessoryId}`;
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
                return response.json();
            })
            .then(data => {
                console.log(data); 
           //     location.reload();
            })
            .catch(error => {
                console.error('There was an error!', error);
            });
        });
    });

    document.getElementById('searchForm').addEventListener('submit', function(event) {
        event.preventDefault();
        
        var query = document.getElementById('searchInput').value;
        var category = <?php echo json_encode($category); ?>;

        fetch('/products/searchAccessory', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ search_query: query,category:category })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
        console.log(data); 
        
        var accessoryRow = document.getElementById('accessoryRow');
        accessoryRow.innerHTML = '';

        var displayedIds = [];
        
        data.accessories.forEach(function(accessory) {
        var card = document.createElement('div');
        card.className = 'col highlight';
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
                </div>
            </div>
        `;
        accessoryRow.prepend(card);
        displayedIds.push(accessory.id);
    });

    var filteredAccessories = accessories.filter(function(accessory) {
        return !displayedIds.includes(accessory.id);
    });

    filteredAccessories.forEach(function(accessory) {
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
                            <button type="button" class="btn btn-sm btn-outline-secondary buy-btn" data-accessory-id="${accessory.id}">Render</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary addToCart-btn" data-accessory-id="${accessory.id}">Delete</button>
                        </div>
                        <small class="text-muted">Price: ${accessory.price}$</small>
                    </div>
                </div>
            </div>
        `;
        accessoryRow.appendChild(card);
            });

             bindEventHandlers();
        })
        .catch(error => {
            console.error('There was an error!', error);
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        bindEventHandlers();
    });

    function bindEventHandlers() {
    document.querySelectorAll('.buy-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var accessoryId = this.dataset.accessoryId;
            window.location.href = `/products/order/${accessoryId}`;
        });
    });
}

    </script>
</body>
