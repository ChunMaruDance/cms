<!DOCTYPE html>
<html lang="en">
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
        <div class="card">
          <form action="createTrendItem" method="POST" enctype="multipart/form-data">
            <img id="imagePreviewTrend" class="card-img-top" src="#" alt="Ваше зображення" style="display: none;">
            <label for="imageUploadTrend" id="imageUploadLabelTrend" class="card-img-top" style="display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; cursor: pointer;">
              <span>Натисніть для вибору зображення</span>
            </label>
            <input type="file" id="imageUploadTrend" name="image" style="display: none;">
            <div class="card-body">
              <input type="text" class="form-control" id="title" name="title" placeholder="Заголовок">
              <textarea class="form-control" id="text" name="text" placeholder="Текст тренду"></textarea>
              <input type="text" class="form-control" id="link" name="link" placeholder="Посилання">
              <button type="submit" class="btn control-button">Додати тренд</button>
            </div>
          </form>
        </div>
      </div>

      <div class="container">
        <?php foreach ($trendsItems as $trend): ?>
                <hr class="featurette-divider">
                <div class="row featurette">
                <div class="col-md-7">
                <h2 class="featurette-heading fw-normal lh-1"><?= $trend->title ?></h2>
                 <p class="lead"><?= $trend->text ?></p>
            </div>
            <div class="col-md-5">
            <img src="<?= $trend->image ?>" class="featurette-image img-fluid mx-auto" style="height: 300px;" alt="<?= $trend->title ?>">
        </div>
            </div>
            <?php endforeach; ?>
        </div>

  <script>
    document.getElementById('imageUploadTrend').addEventListener('change', function() {
      const [file] = this.files;
      if (file) {
        const preview = document.getElementById('imagePreviewTrend');
        const label = document.getElementById('imageUploadLabelTrend');

        preview.src = URL.createObjectURL(file);
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
