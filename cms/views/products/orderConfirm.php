<style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f8f9fa;
            color: #000;
        }
        .order-container {
            margin-top: 50px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            padding: 20px;
            border-radius: 15px;
            background-color: #ffffff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .form-group label {
            font-weight: bold;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn-custom {
            background-color: #000;
            color: #fff;
            transition: all 0.3s ease;
            width: 100%;
            border-radius: 10px;
            margin-top: 20px;
        }
        .btn-custom:hover {
            background-color: #333;
            color: #fff;
        }
        .order-summary {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 10px;
            background-color: #f1f1f1;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }
        .order-summary h3 {
            margin-bottom: 15px;
        }
        .order-summary p {
            margin: 0;
            font-size: 1.1rem;
        }
        .alert {
        padding: 15px;
        background-color: #f44336;
        color: white;
        margin-bottom: 20px;
        border-radius: 5px;
    }
    .alert.error {
        background-color: #f8d7da;
        color: #721c24;
    }
    </style>
<div class="container">
        <h1 class="text-center mb-4">Підтвердження замовлення</h1>
        <div class="order-summary">
            <h3>Номер замовлення: <?php echo $orderNumber; ?></h3>
            <p>Загальна сума замовлення: ₴<?php echo number_format($totalAmount, 2); ?></p>
        </div>
        <div class="order-container">
        <h1 class="text-center mb-3">Особисті Данні</h1>
        <?php if (isset($error_message) && !empty($error_message)): ?>
            <div class="alert error"><?php echo $error_message; ?></div>
        <?php endif; ?>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="email">Електронна пошта</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="name">Ім'я</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="phone">Номер телефону</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="payment_method">Спосіб оплати</label>
                    <select class="form-control" id="payment_method" name="payment_method" required>
                        <option value="credit_card">Кредитна картка</option>
                        <option value="cash_on_delivery">Накладений платіж</option>
                        <option value="paypal">PayPal</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="post_office">Відділення пошти</label>
                    <input type="text" class="form-control" id="post_office" name="post_office" required>
                </div>
                <button type="submit" class="btn btn-custom btn-lg btn-block">Підтвердити замовлення</button>
            </form>
        </div>
    </div>