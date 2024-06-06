    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f8f9fa;
            color: #000;
            margin: 0;
            padding: 20px; 
        }

        .container-2 {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .product-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .product-header h1 {
            font-size: 1.5rem;
        }

        .product-header .product-code {
            font-size: 0.9rem;
            color: #999;
        }

        .product-main {
            display: flex;
        }

        .product-image {
            flex: 1;
            padding: 20px;
        }

        .product-image img {
            width: 100%;
            border-radius: 15px;
        }

        .product-details {
            flex: 2;
            padding: 20px;
        }

        .product-title {
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        .product-price {
            font-size: 1.5rem;
            color: #f00;
            margin-bottom: 20px;
        }

        .product-status {
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .product-status.in-stock {
            color: #28a745;
        }

        .product-status.out-of-stock {
            color: #dc3545;
        }

        .product-buttons {
            display: flex;
            justify-content: space-between;
        }

        .product-buttons button {
            width: 48%;
            padding: 10px;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .product-buttons .buy-btn {
            background-color: #f00;
            color: #fff;
        }

        .product-buttons .buy-btn:hover {
            background-color: #c00;
        }

        .product-buttons .cart-btn {
            background-color: #000;
            color: #fff;
        }

        .product-buttons .cart-btn:hover {
            background-color: #333;
        }

        .product-specs,
        .product-delivery,
        .product-payment,
        .product-reviews {
            margin-top: 20px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }

        .product-specs h2,
        .product-delivery h2,
        .product-payment h2,
        .product-reviews h2 {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .product-specs dl,
        .product-delivery dl,
        .product-payment dl,
        .product-reviews dl {
            display: flex;
            flex-wrap: wrap;
        }

        .product-specs dl dt,
        .product-delivery dl dt,
        .product-payment dl dt,
        .product-reviews dl dt {
            flex: 1 1 30%;
            font-weight: bold;
        }

        .product-specs dl dd,
        .product-delivery dl dd,
        .product-payment dl dd,
        .product-reviews dl dd {
            flex: 1 1 70%;
            margin: 0;
        }
    </style>

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



