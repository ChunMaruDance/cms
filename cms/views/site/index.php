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
    <hr class="featurette-divider">
    <div class="row featurette">
      <div class="col-md-7">
        <h2 class="featurette-heading fw-normal lh-1">First featurette heading. <span class="text-body-secondary">It’ll blow your mind.</span></h2>
        <p class="lead">Some great placeholder content for the first featurette here. Imagine some exciting prose here.</p>
      </div>
      <div class="col-md-5">
        <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="var(--bs-secondary-bg)"></rect><text x="50%" y="50%" fill="var(--bs-secondary-color)" dy=".3em">500x500</text></svg>
      </div>
    </div>
    <hr class="featurette-divider">
    <div class="row featurette" data-aos="fade-up">
      <div class="col-md-7 order-md-2">
        <h2 class="featurette-heading fw-normal lh-1">أوه نعم، هذا جيد. <span class="text-muted"> شاهد بنفسك. </span></h2>
        <p class="lead">عندما تضحك أو تبكي، فإننا نعرض عواطفنا مما يسمح للأخرين بإلقاء نظرة خاطفة على أفكارنا أثناء "قراءة" وجوهنا. إن النسيج العضلي في مكونات الوجه البشري، مثل: الجبين والخدين والعينين والشفاه والفكين.</p>
      </div>
      <div class="col-md-5 order-md-1">
        <img src="/mnt/data/example.png" class="featurette-image img-fluid mx-auto" alt="Generic placeholder image">
      </div>
    </div>
    <hr class="featurette-divider">
    <div class="row featurette" data-aos="fade-up">
      <div class="col-md-7">
        <h2 class="featurette-heading fw-normal lh-1">وجه الإنسان المذهل. <span class="text-muted"> اكتشف المزيد. </span></h2>
        <p class="lead">الوجه البشري قادر على عرض مجموعة مذهلة من العواطف والإشارات، مما يسمح لنا بالتواصل بطرق معقدة وفريدة من نوعها. إن فهم تعابير الوجه يمكن أن يقدم رؤى قيمة في عالم النفس البشرية.</p>
      </div>
      <div class="col-md-5">
        <img src="/mnt/data/example.png" class="featurette-image img-fluid mx-auto" alt="Generic placeholder image">
      </div>
    </div>
  </div>
    
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
</body>
