<?php
$this->Title = 'Замовлення';
?>
<head>
  <link rel="stylesheet" href="/css/ordersViewPage.css">
</head>
<body>
<section class="py-5 text-center container">
        <div class="row py-lg-2">
            <div class="col-lg-7 col-md-8 mx-auto">
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
                <button class="btn-black" id="sortByCancellation">Сортувати за Скасуванням</button>
            </div>
            </div>
        </div>
</section>

    <div class="container-2" id="ordersContainer">
        <?php foreach ($ordersWithItems as $orderWithItems): ?>
            <div class="order<?php echo $orderWithItems['order']->canceled ? ' canceled' : ''; ?><?php echo $orderWithItems['order']->finished ? ' finished' : ''; ?>"> <!-- Додали класи canceled і finished -->
                <h3>Замовлення №<?php echo htmlspecialchars($orderWithItems['order']->order_number); ?></h3>
                <p>Електронна пошта: <?php echo htmlspecialchars($orderWithItems['order']->user_email); ?></p>
                <p>Ім'я: <?php echo htmlspecialchars($orderWithItems['order']->user_name); ?></p>
                <p>Телефон: <?php echo htmlspecialchars($orderWithItems['order']->user_phone); ?></p>
                <p>Метод оплати: <?php echo htmlspecialchars($orderWithItems['order']->payment_method); ?></p>
                <p>Відділення пошти: <?php echo htmlspecialchars($orderWithItems['order']->post_office); ?></p>
                <p>Сума замовлення: ₴<?php echo number_format($orderWithItems['order']->total_amount, 2); ?></p>
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
            return a.order.finished - b.order.finished;
        });
        renderOrders();
    });

    document.getElementById('sortByAmount').addEventListener('click', function() {
        ordersWithItems.sort(function(a, b) {
            return a.order.total_amount - b.order.total_amount;
        });
        renderOrders();
    });

    document.getElementById('sortByCancellation').addEventListener('click', function() {
        ordersWithItems.sort(function(a, b) {
            return b.order.canceled - a.order.canceled;
        });
        renderOrders();
    });

    function renderOrders() {
        var ordersContainer = document.getElementById('ordersContainer');
        ordersContainer.innerHTML = '';

        ordersWithItems.forEach(function(orderWithItems) {
            var orderDiv = document.createElement('div');
            var classes = 'order';
            if (orderWithItems.order.canceled) {
                classes += ' canceled';
            }
            if (orderWithItems.order.finished) {
                classes += ' finished';
            }
            orderDiv.className = classes;

            orderDiv.innerHTML = `
                <h3>Замовлення №${orderWithItems.order.order_number}</h3>
                <p>Електронна пошта: ${orderWithItems.order.user_email}</p>
                <p>Ім'я: ${orderWithItems.order.user_name}</p>
                <p>Телефон: ${orderWithItems.order.user_phone}</p>
                <p>Метод оплати: ${orderWithItems.order.payment_method}</p>
                <p>Відділення пошти: ${orderWithItems.order.post_office}</p>
                <p>Сума замовлення: ₴${parseFloat(orderWithItems.order.total_amount).toFixed(2)}</p>
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
            ordersWithItems.forEach(orderWithItems => {
                if (orderWithItems.order.id === parseInt(orderId)) {
                    orderWithItems.order.finished = (status === '1');
                }
            });
            renderOrders();
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
            ordersWithItems = data.orders;
            renderOrders();
        })
        .catch(error => {
            console.error('There was an error!', error);
        });
    });

    renderOrders();
</script>
</body>