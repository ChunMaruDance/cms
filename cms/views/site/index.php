<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/category.css"> 
  <link rel="stylesheet" href="css/main_banner.css"> 
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">
  <style>
    .featurette-divider {
      margin: 5rem 0;
    }

    .featurette-heading {
      font-weight: 300;
      line-height: 1;
      letter-spacing: -.05rem;
    }

    .featurette {
      margin-bottom: 5rem;
    }

    .featurette-image {
      width: 100%;
      height: auto;
    }

    .btn-delete {
      background-color: black;
      color: white;
      border: none;
      cursor: pointer;
    }

    .btn-delete:hover {
      background-color: white;
      color: black;
    }

    .learn-more-link {
      color: black;
      text-decoration: none;
      font-weight: bold;
      font-size: 18px;
    }

    /* Зміна стилю при наведенні курсора на текстове посилання */
    .learn-more-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <header>
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <?php foreach ($bannerItems as $key => $bannerItem): ?>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?php echo $key; ?>" <?php if ($key === 0) echo 'class="active"'; ?> aria-label="Slide <?php echo $key + 1; ?>"></button>
        <?php endforeach; ?>
      </div>
      <div class="carousel-inner">
        <?php foreach ($bannerItems as $key => $bannerItem): ?>
          <div class="carousel-item <?php if ($key === 0) echo 'active'; ?>" style="background-image: url('<?php echo $bannerItem->image; ?>');">
            <div class="carousel-caption">
              <a class="btn btn-outline-light btn-lg" href="<?php echo $bannerItem->link; ?>" role="button">View</a>
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

  <section class="category-section my-4">
    <div class="container">
      <h2 class="text-center text-uppercase fw-bold mb-4" data-aos="fade-up">Категорії</h2> 
      <hr class="w-100 mx-auto" data-aos="fade-up">
      <div class="d-flex justify-content-center gap-3 flex-wrap">
        <?php foreach ($categories as $key => $category): ?>
          <a href="/products/view/<?php echo $category->title; ?>" class="category-link" style="color: inherit; text-decoration: none;" data-aos="fade-up" data-aos-delay="<?php echo $key * 100; ?>">
            <div class="category-card d-flex flex-column align-items-center text-center p-3">
              <img src="<?php echo $category->image; ?>" alt="<?php echo $category->title; ?>" class="category-image mb-2">
              <span class="category-name"><?php echo $category->title; ?></span>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <div class="container">
    <?php foreach ($trendsItems as $index => $trend): ?>
      <?php $aos_delay = $index * 100; ?>
      <?php if ($index % 2 == 0): ?>
        <hr class="featurette-divider">
        <div class="row featurette" data-aos="fade-up" data-aos-delay="<?= $aos_delay ?>">
          <div class="col-md-7 d-flex flex-column align-items-center justify-content-center text-center">
            <div>
              <h2 class="featurette-heading fw-normal lh-1"><?= $trend->title ?></h2>
              <p class="lead"><?= $trend->text ?></p>
              <a href="<?= $trend->link ?>" class="learn-more-link">Дізнатися більше</a>
            </div>
          </div>
          <div class="col-md-5">
            <img src="<?= $trend->image ?>" class="featurette-image img-fluid mx-auto" style="height: 300px;" alt="<?= $trend->title ?>">
          </div>
        </div>
      <?php else: ?>
        <hr class="featurette-divider">
        <div class="row featurette" data-aos="fade-up" data-aos-delay="<?= $aos_delay ?>">
          <div class="col-md-5">
            <img src="<?= $trend->image ?>" class="featurette-image img-fluid mx-auto" style="height: 300px;" alt="<?= $trend->title ?>">
          </div>
          <div class="col-md-7 d-flex flex-column align-items-center justify-content-center text-center">
            <div>
              <h2 class="featurette-heading fw-normal lh-1"><?= $trend->title ?></h2>
              <p class="lead"><?= $trend->text ?></p>
              <a href="<?= $trend->link ?>" class="learn-more-link">Дізнатися більше</a>
            </div>
          </div>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>

  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
</body>
</html>
