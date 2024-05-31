<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Редагування трендів</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
  <style>
    .card {
      margin-bottom: 20px;
      border: none;
    }

    .card-img-top {
      height: 300px;
      width: 100%;
      cursor: pointer;
      object-fit: cover;
    }

    .control-button {
      width: 100%;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: black;
      color: white;
      font-size: 16px;
      margin-top: 10px;
      border: none;
      cursor: pointer;
    }

    .card-body {
      padding: 20px;
    }

    .form-control {
      margin-bottom: 10px;
      border: 1px solid #ced4da;
      border-radius: 5px;
      padding: 10px;
      width: 100%;
    }

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

    .input-container {
      width: 100%;
    }

    .image-upload-container {
      position: relative;
      height: 300px;
    }

    .image-upload-label {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: #f8f9fa;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
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
  </style>
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
                <button class="btn btn-delete" onclick="deleteTrend(<?= $trend->id ?>)">Видалити</button>
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
                <button class="btn btn-delete" onclick="deleteTrend(<?= $trend->id ?>)">Видалити</button>
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
</html>
