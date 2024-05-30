<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Замовлення</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
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
        h1 {
            text-align: center;
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
        select[name="status"]::-ms-expand {
            display: none;
        }
        select[name="status"] option {
            background-color: #fff;
            color: #333;
        }
    </style>
</head>
<body>
    <h1>Усі замовлення</h1>
    <div class="container-2">
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
                    <form action="updateOrderStatus" method="post">
                        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($orderWithItems['order']->id); ?>">
                        <select name="status" onchange="this.form.submit()">
                            <option value="0" <?php echo !$orderWithItems['order']->finished ? 'selected' : ''; ?>>В процесі</option>
                            <option value="1" <?php echo $orderWithItems['order']->finished ? 'selected' : ''; ?>>Завершено</option>
                        </select>
                    </form>
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
</body>
</html>
