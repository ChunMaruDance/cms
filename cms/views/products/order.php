<?php
$this->Title = 'Замовлення';
?>
<head>
  <link rel="stylesheet" href="/css/orderPage.css">
</head>

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