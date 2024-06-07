<?php
$this->Title = 'Аксесуар';
?>
<head>
  <link rel="stylesheet" href="/css/accessoryPage.css">
</head>

<body>
    <div class="container-2">
        <div class="product-header">
            <h1><?php echo $accessory->title; ?></h1>
            <span class="product-code">КОД ТОВАРУ <?php echo $accessory->id; ?></span>
        </div>
        <div class="product-main">
            <div class="product-image">     
                <img src="<?php echo $accessory->image; ?>" alt="Disney Wallet">
            </div>
            <div class="product-details">
                <h2 class="product-title"><?php echo $accessory->title; ?></h2>
                <div class="product-price"><?php echo $accessory->price; ?>$</div>
                <div class="product-status <?php echo $accessory->quantity > 0 ? 'in-stock' : 'out-of-stock'; ?>">
                    <?php echo $accessory->quantity > 0 ? 'В НАЯВНОСТІ' : 'НЕ В НАЯВНОСТІ'; ?>
                </div>
                <div class="product-buttons" <?php if ($accessory->quantity == 0) echo 'style="display: none;"'; ?>>
                    <button class="buy-btn" data-accessory-id="<?php echo $accessory->id; ?>">КУПИТИ</button>
                    <button class="cart-btn" data-accessory-id="<?php echo $accessory->id; ?>">ДОДАТИ ДО КОШИКУ</button>
                </div>
            </div>
        </div>
        <div class="product-specs">
            <h2>ХАРАКТЕРИСТИКИ</h2>
            <dl>
                <dt>Колір:</dt>
                <dd><?php echo $accessory->color; ?></dd>
                <dt>Матеріал:</dt>
                <dd><?php echo $accessory->material; ?></dd>
                <dt>Виробник:</dt>
                <dd><?php echo $accessory->manufacturer; ?></dd>
                <dt>Розміри:</dt>
                <dd><?php echo $accessory->sizes; ?></dd>
            </dl>
        </div>
        <div class="product-delivery">
            <h2>ДОСТАВКА</h2>
            <dl>
                <dt>Нова пошта в відділення:</dt>
                <dd>Вартість: близько 55 грн. Термін: 1-3 дні</dd>
                <dt>Нова пошта адресна доставка:</dt>
                <dd>Вартість: близько 75 грн. Термін: 1-3 дні</dd>
                <dt>Укрпошта Експрес в відділення:</dt>
                <dd>Вартість: близько 35 грн. Термін: 2-4 дні</dd>
            </dl>
        </div>
        <div class="product-payment">
            <h2>ОПЛАТА</h2>
            <dl>
                <dt>Оплата при отриманні товару:</dt>
                <dd>Нова пошта (20 грн + 2% від суми замовлення)</dd>
            </dl>
        </div>
        <div class="product-payment">
            <h2>Опис</h2>
            <p><?php echo $accessory->description; ?></p>
        </div>
    
    </div>

    <script>
    document.querySelectorAll('.cart-btn').forEach(function(btn) {
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
</body>



