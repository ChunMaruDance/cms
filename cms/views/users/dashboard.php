<?php
$this->Title = 'Панель Управління';
?>
<head>
  <title>Control Panel</title>
  <link rel="stylesheet" href="/css/dashboard.css">
</head>
<body>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-6 d-flex flex-column align-items-center">
        <a href="/mainPage/renderBanner" class="btn control-button">Банер</a>
        <a href="/mainPage/renderTrends" class="btn control-button">Тренди</a>
        <a href="accessories" class="btn control-button">Товари</a>
        <a href="categories" class="btn control-button">Категорії</a>
        <a href="/reviews/view" class="btn control-button">Повідомлення</a>
        <a href="/products/ordersView" class="btn control-button">Замовлення</a>
        <a href="/mailing/view" class="btn control-button">Розсилка</a>
      </div>
      <div class="col-md-6 toggle-switch-container">
        <div class="toggle-switch">
          <span>Відображення банера</span>
          <input type="checkbox" id="toggleBanner" <?php echo $config['banner'] ? 'checked' : ''; ?> onchange="toggleFeature('banner', this.checked)">
          <label for="toggleBanner"></label>
        </div>
        <div class="toggle-switch">
          <span>Відображення Трендів</span>
          <input type="checkbox" id="toggleTrends" <?php echo $config['trends'] ? 'checked' : ''; ?> onchange="toggleFeature('trends', this.checked)">
          <label for="toggleTrends"></label>
        </div>
        <div class="toggle-switch">
          <span>Відображення Категорій</span>
          <input type="checkbox" id="toggleCategories" <?php echo $config['categories'] ? 'checked' : ''; ?> onchange="toggleFeature('categories', this.checked)">
          <label for="toggleCategories"></label>
        </div>
        <div class="toggle-switch">
          <span>Відображення Інформаційних елементів</span>
          <input type="checkbox" id="toggleInfo" <?php echo $config['info'] ? 'checked' : ''; ?> onchange="toggleFeature('info', this.checked)">
          <label for="toggleInfo"></label>
        </div>
        <div class="toggle-switch">
          <span>Відображення Форми підписки</span>
          <input type="checkbox" id="toggleSubscription" <?php echo $config['subscription'] ? 'checked' : ''; ?> onchange="toggleFeature('subscription', this.checked)">
          <label for="toggleSubscription"></label>
        </div>
      </div>
    </div>
  </div>
  <script>
    function toggleFeature(feature, isEnabled) {
      fetch(`/mainPage/toggleFeature`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ feature, isEnabled }),
      })
      .then(response => response.json())
      .then(data => {
        console.log('Success:', data);
      })
      .catch((error) => {
        console.error('Error:', error);
      });
    }
  </script>
</body>
