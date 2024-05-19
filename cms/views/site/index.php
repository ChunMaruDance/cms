<head>
  <meta charset="UTF-8">
  <title>My Website</title>
  <link rel="stylesheet" href="css/category.css"> 
</head>

<header>
  <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active" style="background-image: url('files/images/imgpager1.webp');">
        <div class="carousel-caption">
          <a data-mdb-ripple-init class="btn btn-outline-light btn-lg" href="/news/index/watch" role="button">View</a>
        </div>
      </div>
      <div class="carousel-item" style="background-image: url('files/images/glassesimg1.webp')">
        <div class="carousel-caption">
          <a data-mdb-ripple-init class="btn btn-outline-light btn-lg" href="/news/index/wallet" role="button">View</a>
        </div>
      </div>
      <div class="carousel-item" style="background-image: url('files/images/backpacksimg3.webp')">
        <div class="carousel-caption">
        <a data-mdb-ripple-init class="btn btn-outline-light btn-lg" href="/news/index/backpacks  " role="button">View</a>
        </div>
      </div>
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
        <div class="category-card d-flex flex-column align-items-center text-center p-3">
          <img src="<?php echo $category->image; ?>" alt="<?php echo $category->title; ?>" class="category-image mb-2">
          <span class="category-name"><?php echo $category->title; ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

