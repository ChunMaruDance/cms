<head>
  <title>Subscription Form</title>
  <link rel="stylesheet" href="css/category.css">
  <link rel="stylesheet" href="css/main_banner.css">
  <link rel="stylesheet" href="css/subscription.css">
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">
</head>
<body>
<?php if ($config['banner']): ?>
  <header data-aos="fade-up">
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <?php foreach ($bannerItems as $key => $bannerItem): ?>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?php echo $key; ?>" <?php if ($key === 0) echo 'class="active"'; ?> aria-label="Slide <?php echo $key + 1; ?>"></button>
        <?php endforeach; ?>
      </div>
      <div class="carousel-inner">
        <?php foreach ($bannerItems as $key => $bannerItem): ?>
          <div class="carousel-item <?php if ($key === 0) echo 'active'; ?>" style="background-image: url('<?php echo $bannerItem['image']; ?>');" data-aos="fade-up">
            <div class="carousel-caption" data-aos="fade-up">
              <a class="btn btn-outline-light btn-lg" href="<?php echo $bannerItem['link']; ?>" role="button">View</a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </header>
  <?php endif; ?>


  <?php if ($config['categories']): ?>
  <section class="category-section my-4" data-aos="fade-up">
    <div class="container">
      <h2 class="text-center text-uppercase fw-bold mb-4" data-aos="fade-up">Категорії</h2> 
      <hr class="w-100 mx-auto" data-aos="fade-up">
      <div class="d-flex justify-content-center gap-3 flex-wrap">
        <?php foreach ($categories as $key => $category): ?>
          <a href="/products/view/<?php echo $category['title']; ?>" class="category-link" style="color: inherit; text-decoration: none;" data-aos="fade-up" data-aos-delay="<?php echo $key * 100; ?>">
            <div class="category-card d-flex flex-column align-items-center text-center p-3">
              <img src="<?php echo $category['image']; ?>" alt="<?php echo $category['title']; ?>" class="category-image mb-2">
              <span class="category-name"><?php echo $category['title']; ?></span>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <?php if ($config['trends']): ?>
  <div class="container">
    <?php foreach ($trendsItems as $index => $trend): ?>
      <?php $aos_delay = $index * 100; ?>
      <?php if ($index % 2 == 0): ?>
        <hr class="featurette-divider">
        <div class="row featurette" data-aos="fade-up" data-aos-delay="<?= $aos_delay ?>">
          <div class="col-md-7 d-flex flex-column align-items-center justify-content-center text-center">
            <div>
              <h2 class="featurette-heading fw-normal lh-1"><?= $trend['title'] ?></h2>
              <p class="lead"><?= $trend['text'] ?></p>
              <a href="<?= $trend['link'] ?>" class="learn-more-link">Дізнатися більше</a>
            </div>
          </div>
          <div class="col-md-5">
            <img src="<?= $trend['image'] ?>" class="featurette-image img-fluid mx-auto" style="height: 300px;" alt="<?= $trend['title'] ?>">
          </div>
        </div>
      <?php else: ?>
        <hr class="featurette-divider">
        <div class="row featurette" data-aos="fade-up" data-aos-delay="<?= $aos_delay ?>">
          <div class="col-md-5">
            <img src="<?= $trend['image'] ?>" class="featurette-image img-fluid mx-auto" style="height: 300px;" alt="<?= $trend['title'] ?>">
          </div>
          <div class="col-md-7 d-flex flex-column align-items-center justify-content-center text-center">
            <div>
              <h2 class="featurette-heading fw-normal lh-1"><?= $trend['title'] ?></h2>
              <p class="lead"><?= $trend['text'] ?></p>
              <a href="<?= $trend['link'] ?>" class="learn-more-link">Дізнатися більше</a>
            </div>
          </div>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <?php if ($config['info']): ?>
  <section class="additional-info" data-aos="fade-up">
    <br>
    <div class="container text-center">
      <div class="row">
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="info-box">
            <img src="https://img2.ans-media.com/ua/cms/homepage-usp/60ac4297cfbba1.46116791" alt="Безкоштовна доставка" class="info-icon">
            <h3>Безкоштовна доставка</h3>
            <p>Від 2000 грн. 4-7 робочих днів</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
          <div class="info-box">
            <img src="https://img2.ans-media.com/ua/cms/homepage-usp/61f95591249a08.88529166" alt="30 днів на повернення" class="info-icon">
            <h3>30 днів на повернення</h3>
            <p>Лише оригінальні товари</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
          <div class="info-box">
            <img src="https://img2.ans-media.com/ua/cms/homepage-usp/60ac42ed054b59.98201091" alt="Заощаджуй з Answear Club" class="info-icon">
            <h3>Заощаджуй з Answear Club</h3>
            <p>Іноді навіть -50%</p>
          </div>
        </div>
      </div>
    <br>
  </section>
  <?php endif; ?>
  
  <?php if ($config['subscription']): ?>
  <section class="subscription-section" data-aos="fade-up">
    <div class="container">
      <div class="subscription-form">
        <div class="text-container">
          <h3>Отримуйте останні новини та спеціальні пропозиції</h3>
          <p>Підпишіться на нашу розсилку, щоб бути в курсі всіх оновлень та отримувати спеціальні пропозиції</p>
          <small>
            **Залишайтеся з нами, щоб отримувати інформацію про нові продукти та події. Ми обіцяємо надсилати лише цікаву та корисну інформацію.
          </small>
        </div>
        <div class="form-container">
          <form id="subscription-form">
            <div class="form-group">
              <input type="email" class="form-control" id="email" placeholder="Введіть адресу e-mail" required>
              <button type="submit" class="btn btn-dark">Підписатися</button>
            </div>
          </form>
          <div id="error-text" class="error-text" style="display: none;"></div>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>

  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init();

    document.getElementById('subscription-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const email = document.getElementById('email').value;
    const errorText = document.getElementById('error-text');

    fetch('/mailing/addEmail', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ email: email })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        errorText.style.display = 'none';
        alert(data.message);
      } else {
        errorText.style.display = 'block';
        errorText.textContent = data.message;
      }
    })
    .catch(error => {
      console.error('Error:', error);
      errorText.style.display = 'block';
      errorText.textContent = 'Виникла помилка. Спробуйте пізніше.';
    });
  });

  </script>
</body>
