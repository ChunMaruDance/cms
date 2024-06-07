<?php
$this->Title = 'Редагування Трендів';
?>
<head>
  <link rel="stylesheet" href="/css/renderTrendsPage.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
</head>

<body>
  <header class="bg-light py-5">
    <div class="container text-center">
      <h1 class="display-4 fw-bold">Редагування трендів</h1>
      <?php if (isset($error_message) && !empty($error_message)): ?>
        <div class="alert alert-danger" role="alert"><?php echo $error_message; ?></div>
      <?php endif; ?>
    </div>
  </header>

  <div class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <form action="createTrendItem" method="POST" enctype="multipart/form-data" class="featurette">
          <div class="row">
            <div class="col-md-5 image-upload-container">
              <img id="imagePreviewTrend" class="featurette-image img-fluid mx-auto" src="#" alt="Ваше зображення" style="height: 300px; display: none;">
              <label for="imageUploadTrend" id="imageUploadLabelTrend" class="featurette-image img-fluid mx-auto image-upload-label">
                <span>Натисніть для вибору зображення</span>
              </label>
              <input type="file" id="imageUploadTrend" name="image" style="display: none;">
            </div>
            <div class="col-md-7 d-flex flex-column align-items-center justify-content-center text-center">
              <div class="card-body input-container">
                <input type="text" class="form-control" id="title" name="title" placeholder="Заголовок">
                <textarea class="form-control" id="text" name="text" placeholder="Текст тренду"></textarea>
                <input type="text" class="form-control" id="link" name="link" placeholder="Посилання">
                <button type="submit" class="btn control-button">Додати тренд</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="container">
      <?php foreach ($trendsItems as $index => $trend): ?>
        <?php if ($index % 2 == 0): ?>
          <hr class="featurette-divider">
          <div class="row featurette">
            <div class="col-md-7 d-flex flex-column align-items-center justify-content-center text-center">
              <div>
                <h2 class="featurette-heading fw-normal lh-1"><?= $trend->title ?></h2>
                <p class="lead"><?= $trend->text ?></p>
                <form action="deleteTrendsItem/<?php echo $trend->id; ?>" method="POST">
                    <button type="submit" class="btn btn-delete">Видалити</button>
                </form>
              </div>
            </div>
            <div class="col-md-5">
              <img src="<?= $trend->image ?>" class="featurette-image img-fluid mx-auto" style="height: 300px;" alt="<?= $trend->title ?>">
            </div>
          </div>
        <?php else: ?>
          <hr class="featurette-divider">
          <div class="row featurette">
            <div class="col-md-5">
              <img src="<?= $trend->image ?>" class="featurette-image img-fluid mx-auto" style="height: 300px;" alt="<?= $trend->title ?>">
            </div>
            <div class="col-md-7 d-flex flex-column align-items-center justify-content-center text-center">
              <div>
                <h2 class="featurette-heading fw-normal lh-1"><?= $trend->title ?></h2>
                <p class="lead"><?= $trend->text ?></p>
                <form action="deleteTrendsItem/<?php echo $trend->id; ?>" method="POST">
                    <button type="submit" class="btn btn-delete">Видалити</button>
                </form>
              </div>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>

  <script>
    document.getElementById('imageUploadTrend').addEventListener('change', function() {
      const file = this.files[0];
      if (file) {
        const preview = document.getElementById('imagePreviewTrend');
        const label = document.getElementById('imageUploadLabelTrend');

        preview.src = URL.createObjectURL(file);
        preview.onload = () => URL.revokeObjectURL(preview.src);
        preview.style.display = 'block';
        label.style.display = 'none';
      }
    });

    document.getElementById('imagePreviewTrend').addEventListener('click', function() {
      document.getElementById('imageUploadTrend').click();
    });
  </script>
</body>