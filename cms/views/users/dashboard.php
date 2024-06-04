<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Control Panel</title>
  <style>
    .control-button {
      width: 200px;
      height: 50px; 
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: black;
      color: white;
      font-size: 18px; 
      margin-bottom: 20px;
      padding: 10px;
      text-decoration: none;
      border: none; 
      border-radius: 5px;
    }
    .control-button:hover {
      background-color: #333;
    }
    .toggle-switch {
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 300px;
      margin-bottom: 20px;
    }
    .toggle-switch-container {
      display: flex;
      flex-direction: column;
    }
    /* Додано нові стилі для елементів switch */
    .toggle-switch input[type="checkbox"] {
      height: 0;
      width: 0;
      visibility: hidden;
    }
    .toggle-switch label {
      cursor: pointer;
      text-indent: 0;
      width: 40px;
      height: 20px;
      background: grey;
      display: block;
      border-radius: 20px;
      position: relative;
    }
    .toggle-switch label:after {
      content: '';
      position: absolute;
      top: 2px;
      left: 2px;
      width: 16px;
      height: 16px;
      background: #fff;
      border-radius: 50%;
      transition: 0.3s;
    }
    .toggle-switch input:checked + label {
      background: #69b4ff;
    }
    .toggle-switch input:checked + label:after {
      left: calc(100% - 2px);
      transform: translateX(-100%);
    }
    .toggle-switch label:active:after {
      width: 45px;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-6 d-flex flex-column align-items-center">
        <a href="/mainPage/renderBanner" class="btn control-button">Банер</a>
        <a href="/mainPage/renderTrends" class="btn control-button">Тренди</a>
        <a href="accessories" class="btn control-button">Товари</a>
        <a href="categories" class="btn control-button">Категорії</a>
        <a href="/reviews/view" class="btn control-button">Відгуки</a>
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
</html>
