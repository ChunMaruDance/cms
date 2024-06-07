<?php
$this->Title = 'Редагування Банеру';
?>
<head>
  <link rel="stylesheet" href="/css/renderBannerPage.css">
</head>

<div class="container mt-5">
    <h1 class="text-center mb-4">Редагування банера</h1>
    
    <?php if (isset($error_message) && !empty($error_message)): ?>
            <div class="alert alert-danger" role="alert" ><?php echo $error_message; ?></div>
        <?php endif; ?>
     
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card">
                <form action="createBannerItem" method="POST" enctype="multipart/form-data">
                    <img id="imagePreview" class="card-img-top" src="#" alt="Ваше зображення" style="display: none;">
                    <label for="imageUpload" id="imageUploadLabel" class="card-img-top" style="display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; cursor: pointer;">
                        <span>Натисніть для вибору зображення</span>
                    </label>
                    <input type="file" id="imageUpload" name="image" style="display: none;">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <input type="text" class="form-control mb-3" id="link" name="link" placeholder="Введіть посилання">
                        <button type="submit" class="btn control-button">Submit</button>
                    </div>
                </form>
            </div>
        </div>

        <?php 
        foreach ($bannerItems as $bannerItem): ?>
            <div class="col-md-6 mb-3">
                <div class="card">
                    <img src="<?php echo $bannerItem->image; ?>" class="card-img-top" alt="Banner Image">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title"><?php echo $bannerItem->link; ?></h5>
                        <br>
                        <form action="deleteBannerItem/<?php echo $bannerItem->id; ?>" method="POST">
                            <input type="hidden" name="image_id" value="<?php echo $bannerItem->id; ?>">
                            <button type="submit" class="btn btn-danger">Видалити</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    document.getElementById('imageUpload').addEventListener('change', function() {
        const [file] = this.files;
        if (file) {
            const preview = document.getElementById('imagePreview');
            const label = document.getElementById('imageUploadLabel');
            
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
            label.style.display = 'none';
        }
    });

    document.getElementById('imagePreview').addEventListener('click', function() {
        document.getElementById('imageUpload').click();
    });
</script>
