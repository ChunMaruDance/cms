<style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f8f9fa;
            color: #000;
        }
        .accessory-container {
            margin-top: 50px;
        }
        .accessory-image {
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .accessory-details {
            margin-top: 30px;
        }
        .btn-custom {
            margin-top: 15px;
            width: 100%;
            border-radius: 10px;
            background-color: #000;
            color: #fff;
            border: 2px solid #000;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #fff;
            color: #000;
        }
        .accessory-title {
            font-weight: bold;
            font-size: 2rem;
        }
        .accessory-category, .accessory-price, .accessory-description {
            margin-bottom: 20px;
        }
        .accessory-price {
            font-size: 1.5rem;
        }
        .accessory-description {
            font-size: 1.1rem;
        }
        .container-fluid {
            background-color: #ffffff;
            padding: 20px 50px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        

    </style>

<div class="container accessory-container">
    <div class="row">
        <div class="col-md-6">
            <img src="<?php echo $accessory->image; ?>" alt="<?php echo $accessory->title; ?>" class="accessory-image">
        </div>
        <div class="col-md-6">
            <div class="container-fluid">
                <h2 class="accessory-title"><?php echo $accessory->title; ?></h2>
                <p class="accessory-info">
                    <span class="text-muted mr-2">Категорія:</span>
                    <button type="button" class="btn btn-sm btn-outline-secondary render-btn"><?php echo $accessory->category; ?></button>
                </p>
                <p class="accessory-price">Ціна: <span class="font-weight-bold">₴<?php echo $accessory->price; ?></span></p>
                <p class="accessory-description"><?php echo $accessory->description; ?></p>
                <div class="accessory-details">
                    <button class="btn btn-custom buy-btn" data-accessory-id="<?php echo $accessory->id; ?>" >Замовити</button>
                    <button class="btn btn-custom addToCart-btn" data-accessory-id="<?php echo $accessory->id; ?>" >Додати до корзини</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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
                location.reload();
            })
            .catch(error => {
                console.error('There was an error!', error);
            });
        });
    });


    document.querySelectorAll('.buy-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var accessoryId = this.dataset.accessoryId;
            window.location.href = `/products/order/${accessoryId}`;
        });
    });
</script>