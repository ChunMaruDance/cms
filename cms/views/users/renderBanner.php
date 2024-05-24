<style>
    .card {
        height: 100%;
    }
    .card-img-top {
        height: 300px;
        object-fit: cover;
        cursor: pointer; /* Додаємо курсор */
    }

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
        padding: 30px;
    }
</style>

<div class="container mt-5">
    <h1 class="text-center mb-4">Редагування банера</h1>

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card">
                <form action="" method="post" enctype="multipart/form-data">
                    <img id="imagePreview" class="card-img-top" src="#" alt="Ваше зображення" style="display: none;">
                    <label for="imageUpload" id="imageUploadLabel" class="card-img-top" style="display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; cursor: pointer;">
                        <span>Натисніть для вибору зображення</span>
                    </label>
                    <input type="file" id="imageUpload" name="image" style="display: none;">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <select class="form-control mb-3" id="category" name="category">
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?= $category->title ?>"><?= $category->title ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn control-button">Submit</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Випадкові банер-елементи для демонстрації -->
        <?php 
        $bannerImages = [
            (object) ['url' => 'https://via.placeholder.com/300', 'category' => 'Category 1', 'id' => 1],
            (object) ['url' => 'https://via.placeholder.com/300', 'category' => 'Category 2', 'id' => 2],
            (object) ['url' => 'https://via.placeholder.com/300', 'category' => 'Category 3', 'id' => 3]
        ];
        foreach ($bannerImages as $bannerImage): ?>
            <div class="col-md-6 mb-3">
                <div class="card">
                    <img src="<?php echo $bannerImage->url; ?>" class="card-img-top" alt="Banner Image">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title"><?php echo $bannerImage->category; ?></h5>
                        <form action="" method="post">
                            <input type="hidden" name="image_id" value="<?php echo $bannerImage->id; ?>">
                            <button type="submit" class="btn btn-danger">Видалити</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Посилання на Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-m6QwTsr8/jjIxd76aOzA8/LpnsGxWxOHtTMCskK/vBrA6h5dCRyo+Yw4jU5uBqv1" crossorigin="anonymous"></script>
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

    document.getElementById('imageUploadLabel').addEventListener('click', function(event) {
        if (document.getElementById('imagePreview').style.display === 'none') {
        }
    });
</script>
