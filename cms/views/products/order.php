<style>
    body {
        font-family: 'Helvetica Neue', Arial, sans-serif;
        background-color: #f8f9fa;
        color: #000;
    }
    .order-container {
        margin-top: 50px;
    }
    .accessory-item {
        display: flex;
        align-items: center;
        padding: 15px;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        background-color: #ffffff;
    }
    .accessory-image {
        width: 150px;
        height: 150px;
        border-radius: 15px;
        object-fit: cover;
        margin-right: 20px;
    }
    .accessory-details {
        flex: 1;
    }
    .btn-custom {
        background-color: #000;
        color: #fff;
        transition: all 0.3s ease;
    }
    .btn-custom:hover {
        background-color: #333;
        color: #fff;
    }
    .btn-icon {
        background-color: #000;
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 5px;
        transition: all 0.3s ease;
    }
    .btn-icon img {
        width: 20px;
        height: 20px;
    }
    .accessory-title {
        font-weight: bold;
        font-size: 1.5rem;
        margin-bottom: 10px;
    }
    .accessory-category, .accessory-price, .accessory-description {
        margin-bottom: 10px;
    }
    .accessory-price {
        font-size: 1.25rem;
        font-weight: bold;
    }
    .accessory-description {
        font-size: 1rem;
    }
    .cart-summary {
        border-top: 2px solid #dee2e6;
        padding-top: 20px;
        margin-top: 20px;
    }
    .cart-summary h3 {
        font-size: 1.5rem;
        font-weight: bold;
    }
    .cart-summary p {
        font-size: 1.25rem;
    }
  
    .btn-icon.add-more-btn,
    .btn-icon.remove-btn {
        background-color: #fff;
        color: #000;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }
    .btn-icon.add-more-btn:hover,
    .btn-icon.remove-btn:hover {
        background-color: #eee;
        transform: translateY(-2px);
    }

    .accessory-item:hover {
    transform: translateY(-5px);
    transition: transform 0.3s ease;
}
</style>

<div class="container order-container">
    <h1 class="text-center mb-4">Ваше замовлення</h1>
    <div class="order-list">
        <?php foreach ($accesories as $item): ?>
            <div class="accessory-item">
                <img src="<?php echo $item['accessory']->image; ?>" alt="<?php echo $item['accessory']->title; ?>" class="accessory-image " data-accessory-id="<?php echo $item['accessory']->id; ?>">
                <div class="accessory-details">
                    <h2 class="accessory-title"><?php echo $item['accessory']->title; ?></h2>
                    <p class="accessory-price">Ціна: ₴<?php echo $item['accessory']->price; ?></p>
                    <p class="accessory-description"><?php echo $item['accessory']->description; ?></p>
                </div>
                <div class="accessory-quantity d-flex align-items-center">
                    <button class="btn btn-icon remove-btn" data-accessory-id="<?php echo $item['accessory']->id; ?>">
                        <img src="/files/images/minus.png" alt="Remove">
                    </button>
                    <span class="mx-2"><?php echo $item['count']; ?></span>
                    <button class="btn btn-icon add-more-btn" data-accessory-id="<?php echo $item['accessory']->id; ?>">
                        <img src="/files/images/plus.png" alt="Add">
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="cart-summary">
        <h3>Підсумок замовлення</h3>
        <p>Всього товарів: <?php echo array_sum(array_column($accesories, 'count')); ?></p>
        <p>Загальна вартість: ₴<?php echo array_sum(array_map(function($item) {
            return $item['accessory']->price * $item['count'];
        }, $accesories)); ?></p>
       <button class="btn btn-custom btn-lg btn-block btn-order-confirm">Оформити замовлення</button>
    </div>
</div>

<script>

    document.querySelector('.btn-order-confirm').addEventListener('click', function() {
        window.location.href = '/products/orderConfirm';
    });

    document.querySelectorAll('.add-more-btn').forEach(function(btn) {
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

    document.querySelectorAll('.accessory-image').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var accessoryId = this.dataset.accessoryId;
            window.location.href = `/products/accessory/${accessoryId}`;
        });
    });

    document.querySelectorAll('.remove-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var accessoryId = this.dataset.accessoryId;
            fetch('/products/removeFromBasket', {
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
</script>