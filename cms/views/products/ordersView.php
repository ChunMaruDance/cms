<head>
    <title>Замовлення</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container-2 {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff; 
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(45%, 1fr));
            gap: 20px;
        }
        .order {
            padding: 20px;
            border-radius: 10px;
            background-color: #f1f1f1;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .order h3 {
            margin-bottom: 15px;
        }
        .order-items {
            margin-top: 20px;
        }
        .order-item {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            display: flex;
            align-items: center;
            box-sizing: border-box;
        }
        .order-item img {
            max-width: 100px;
            margin-right: 20px;
            border-radius: 10px;
        }
        .order-status {
            font-weight: bold;
            color: #007bff;
        }  
        .btn-black {
            background-color: black;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .btn-black:hover {
            background-color: #333;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .btn-finished {
            background-color: #28a745;
        }
        .btn-finished:hover {
            background-color: #218838;
        }
        .btn-in-progress {
            background-color: #ffc107;
            color: #212529;
        }
        .btn-in-progress:hover {
            background-color: #e0a800;
            color: #212529;
        }
        select[name="status"] {
            padding: 8px 12px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            color: #333;
            outline: none;
            transition: border-color 0.3s ease;
        }
        select[name="status"]:hover,
        select[name="status"]:focus {
            border-color: #007bff;
        }
        select[name="status"] option {
            background-color: #fff;
            color: #333;
        }
        .highlight {
            border: 2px solid yellow;
            background-color: #ffffe0;
        }
    </style>
</head>
<body>
<section class="py-5 text-center container">
        <div class="row py-lg-2">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1>Усі замовлення</h1>
                <form class="w-100" id="searchForm">
                    <div class="input-group"> 
                        <input type="search" class="form-control" placeholder="Search..." aria-label="Search" id="searchInput" name="search_query">
                        <button type="submit" class="btn-black" id="searchButton">Search</button>
                    </div>
                </form>
                <div class="mt-3">
                <button class="btn-black" id="sortByStatus">Сортувати за статусом</button>
                <button class="btn-black" id="sortByAmount">Сортувати за сумою замовлення</button>
            </div>
            </div>            
        </div>
</section>

    <div class="container-2" id="ordersContainer">
        <?php foreach ($ordersWithItems as $orderWithItems): ?>
            <div class="order">
                <h3>Замовлення №<?php echo htmlspecialchars($orderWithItems['order']->order_number); ?></h3>
                <p>Електронна пошта: <?php echo htmlspecialchars($orderWithItems['order']->user_email); ?></p>
                <p>Ім'я: <?php echo htmlspecialchars($orderWithItems['order']->user_name); ?></p>
                <p>Телефон: <?php echo htmlspecialchars($orderWithItems['order']->user_phone); ?></p>
                <p>Метод оплати: <?php echo htmlspecialchars($orderWithItems['order']->payment_method); ?></p>
                <p>Відділення пошти: <?php echo htmlspecialchars($orderWithItems['order']->post_office); ?></p>
                <p>Сума замовлення: $<?php echo number_format($orderWithItems['order']->total_amount, 2); ?></p>
                <p>Статус: 
                    <select name="status" onchange="updateStatus('<?php echo htmlspecialchars($orderWithItems['order']->id); ?>', this.value)">
                        <option value="0" <?php echo !$orderWithItems['order']->finished ? 'selected' : ''; ?>>В процесі</option>
                        <option value="1" <?php echo $orderWithItems['order']->finished ? 'selected' : ''; ?>>Завершено</option>
                    </select>
                </p>
                <div class="order-items">
                    <h4>Елементи замовлення:</h4>
                    <?php foreach ($orderWithItems['items'] as $itemWithAccessory): ?>
                        <div class="order-item">
                            <img src="<?php echo htmlspecialchars($itemWithAccessory['accessory']->image); ?>" alt="<?php echo htmlspecialchars($itemWithAccessory['accessory']->title); ?>">
                            <div>
                                <p>Назва: <?php echo htmlspecialchars($itemWithAccessory['accessory']->title); ?></p>
                                <p>Кількість: <?php echo htmlspecialchars($itemWithAccessory['orderItem']->quantity); ?></p>
                                <p>Ціна: ₴<?php echo number_format($itemWithAccessory['orderItem']->price, 2); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<script>

    var ordersWithItems = <?php echo json_encode($ordersWithItems); ?>;


    document.getElementById('sortByStatus').addEventListener('click', function() {
    ordersWithItems.sort(function(a, b) {
        if (a.order.finished && !b.order.finished) {
            return 1;
        } else if (!a.order.finished && b.order.finished) {
            return -1;
        } else {
            return 0;
        }
    });
    renderOrders();
});

document.getElementById('sortByAmount').addEventListener('click', function() {
    ordersWithItems.sort(function(a, b) {
        return a.order.total_amount - b.order.total_amount;
    });
    renderOrders();
});

function renderOrders() {
    var ordersContainer = document.getElementById('ordersContainer');
    ordersContainer.innerHTML = '';

    ordersWithItems.forEach(function(orderWithItems) {
        var orderDiv = document.createElement('div');
        orderDiv.className = 'order card shadow-sm';
        orderDiv.innerHTML = `
            <h3>Замовлення №${orderWithItems.order.order_number}</h3>
            <p>Електронна пошта: ${orderWithItems.order.user_email}</p>
            <p>Ім'я: ${orderWithItems.order.user_name}</p>
            <p>Телефон: ${orderWithItems.order.user_phone}</p>
            <p>Метод оплати: ${orderWithItems.order.payment_method}</p>
            <p>Відділення пошти: ${orderWithItems.order.post_office}</p>
            <p>Сума замовлення: $${parseFloat(orderWithItems.order.total_amount).toFixed(2)}</p>
            <p>Статус: 
                <select name="status" onchange="updateStatus('${orderWithItems.order.id}', this.value)">
                    <option value="0" ${!orderWithItems.order.finished ? 'selected' : ''}>В процесі</option>
                    <option value="1" ${orderWithItems.order.finished ? 'selected' : ''}>Завершено</option>
                </select>
            </p>
            <div class="order-items">
                <h4>Елементи замовлення:</h4>
                ${orderWithItems.items.map(itemWithAccessory => `
                    <div class="order-item">
                        <img src="${itemWithAccessory.accessory.image}" alt="${itemWithAccessory.accessory.title}">
                        <div>
                            <p>Назва: ${itemWithAccessory.accessory.title}</p>
                            <p>Кількість: ${itemWithAccessory.orderItem.quantity}</p>
                            <p>Ціна: ₴${parseFloat(itemWithAccessory.orderItem.price).toFixed(2)}</p>
                        </div>
                    </div>
                `).join('')}
            </div>
        `;
        ordersContainer.appendChild(orderDiv);
    });
}

    function updateStatus(orderId, status) {
        fetch('updateOrderStatus', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                order_id: orderId,
                status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Status updated successfully');
            } else {
                alert('Failed to update status');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    document.getElementById('searchForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var query = document.getElementById('searchInput').value;

    fetch('searchOrders', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ search_query: query })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log(data); 
        var ordersContainer = document.getElementById('ordersContainer');
     
        ordersContainer.innerHTML = '';

        var displayedIds = [];

        data.orders.forEach(function(orderWithItems) {
            var orderDiv = document.createElement('div');
            orderDiv.className = 'order card shadow-sm';
            orderDiv.classList.add('highlight');
            orderDiv.innerHTML = `
                <h3>Замовлення №${orderWithItems.order.order_number}</h3>
                <p>Електронна пошта: ${orderWithItems.order.user_email}</p>
                <p>Ім'я: ${orderWithItems.order.user_name}</p>
                <p>Телефон: ${orderWithItems.order.user_phone}</p>
                <p>Метод оплати: ${orderWithItems.order.payment_method}</p>
                <p>Відділення пошти: ${orderWithItems.order.post_office}</p>
                <p>Сума замовлення: $${parseFloat(orderWithItems.order.total_amount).toFixed(2)}</p>
                <p>Статус: 
                    <select name="status" onchange="updateStatus('${orderWithItems.order.id}', this.value)">
                        <option value="0" ${!orderWithItems.order.finished ? 'selected' : ''}>В процесі</option>
                        <option value="1" ${orderWithItems.order.finished ? 'selected' : ''}>Завершено</option>
                    </select>
                </p>
                <div class="order-items">
                    <h4>Елементи замовлення:</h4>
                    ${orderWithItems.items.map(itemWithAccessory => `
                        <div class="order-item">
                            <img src="${itemWithAccessory.accessory.image}" alt="${itemWithAccessory.accessory.title}">
                            <div>
                                <p>Назва: ${itemWithAccessory.accessory.title}</p>
                                <p>Кількість: ${itemWithAccessory.orderItem.quantity}</p>
                                <p>Ціна: ₴${parseFloat(itemWithAccessory.orderItem.price).toFixed(2)}</p>
                            </div>
                        </div>
                    `).join('')}
                </div>
            `;
            ordersContainer.appendChild(orderDiv);
            displayedIds.push(orderWithItems.order.id);
        });

        var filteredOrders = ordersWithItems.filter(function(order) {
            return !displayedIds.includes(order.order.id);
        });

        // Render remaining orders
        filteredOrders.forEach(function(orderWithItems) {
            var orderDiv = document.createElement('div');
            orderDiv.className = 'order card shadow-sm';
            orderDiv.innerHTML = `
                <h3>Замовлення №${orderWithItems.order.order_number}</h3>
                <p>Електронна пошта: ${orderWithItems.order.user_email}</p>
                <p>Ім'я: ${orderWithItems.order.user_name}</p>
                <p>Телефон: ${orderWithItems.order.user_phone}</p>
                <p>Метод оплати: ${orderWithItems.order.payment_method}</p>
                <p>Відділення пошти: ${orderWithItems.order.post_office}</p>
                <p>Сума замовлення: $${parseFloat(orderWithItems.order.total_amount).toFixed(2)}</p>
                <p>Статус: 
                    <select name="status" onchange="updateStatus('${orderWithItems.order.id}', this.value)">
                        <option value="0" ${!orderWithItems.order.finished ? 'selected' : ''}>В процесі</option>
                        <option value="1" ${orderWithItems.order.finished ? 'selected' : ''}>Завершено</option>
                    </select>
                </p>
                <div class="order-items">
                    <h4>Елементи замовлення:</h4>
                    ${orderWithItems.items.map(itemWithAccessory => `
                        <div class="order-item">
                            <img src="${itemWithAccessory.accessory.image}" alt="${itemWithAccessory.accessory.title}">
                            <div>
                                <p>Назва: ${itemWithAccessory.accessory.title}</p>
                                <p>Кількість: ${itemWithAccessory.orderItem.quantity}</p>
                                <p>Ціна: ₴${parseFloat(itemWithAccessory.orderItem.price).toFixed(2)}</p>
                            </div>
                        </div>
                    `).join('')}
                </div>
            `;
            ordersContainer.appendChild(orderDiv);
        });
    })
    .catch(error => {
        console.error('There was an error!', error);
    });
});


</script>
</body>
