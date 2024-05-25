<head>
  <meta charset="UTF-8">
  <title>My Website</title>
  <link rel="stylesheet" href="css/category.css"> 
  <link rel="stylesheet" href="css/main_banner.css"> 
</head>
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
            <a data-mdb-ripple-init class="btn btn-outline-light btn-lg" href="<?php echo $bannerItem->link; ?>" role="button">View</a>
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
    <h2 class="text-center text-uppercase fw-bold mb-4">Категорії</h2> 
    <hr class="w-100 mx-auto">
    <div class="d-flex justify-content-center gap-3 flex-wrap">
      <?php foreach ($categories as $category): ?>
        <a href="/products/<?php echo $category->title; ?>" class="category-link" style="color: inherit; text-decoration: none;">
          <div class="category-card d-flex flex-column align-items-center text-center p-3">
            <img src="<?php echo $category->image; ?>" alt="<?php echo $category->title; ?>" class="category-image mb-2">
            <span class="category-name"><?php echo $category->title; ?></span>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>