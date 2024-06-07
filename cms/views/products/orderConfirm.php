<?php
$this->Title = 'Підтвердження замовлення';
?>
<head>
  <link rel="stylesheet" href="/css/orderConfirmPage.css">
</head>

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