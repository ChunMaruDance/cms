<?php

$this->Title = 'Список товарів';

?>


<!DOCTYPE html>
<html lang="en">
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
                                <button type="button" class="btn btn-sm btn-outline-secondary buy-btn" data-accessory-id="${accessory.id}">Купити</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary addToCart-btn" data-accessory-id="${accessory.id}">Додати в Корзину</button>
                            </div>
                            <small class="text-muted">Price: ${accessory.price}$</small>
                        </div>
                    </div>
                </div>
            `;
            document.getElementById('accessoryRow').appendChild(card);
        });

    </script>
</body>
</html>
