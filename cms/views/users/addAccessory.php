<?php
$this->Title = 'Редагування/Додавання аксесуарів';
?>

<head>
  <link rel="stylesheet" href="/css/addAccessoryPage.css">
</head>
<div id="accessoryFormContainer" class="container mt-5">
    <h2 class="mb-4">Create New Accessory</h2>
    <?php if (!empty($error_message)) : ?>
        <div class="alert alert-danger">
            <strong>Error : </strong><?= $error_message ?>
        </div>
    <?php endif; ?>
    <form id="accessoryForm" enctype="multipart/form-data" action="" method="POST">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>
        <div class="form-group">
            <label for="short_description">Short description:</label>
            <textarea class="form-control" id="short_description" name="short_description"></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="text" class="form-control" id="price" name="price">
        </div>
        <div class="form-group">
            <label for="category">Category:</label>
            <select class="form-control" id="category" name="category">
                <?php foreach ($categories as $category) : ?>
                    <option value="<?= $category->title ?>"><?= $category->title ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
        <label for="color">Color:</label>
        <select class="form-control" id="color" name="color">
        <?php foreach ($colors as $color) : ?>
            <option value="<?= $color ?>"><?= $color ?></option>
        <?php endforeach; ?>
        </select>
        </div>
        <div class="form-group">
        <label for="material">Material:</label>
        <select class="form-control" id="material" name="material">
        <?php foreach ($materials as $material) : ?>
            <option value="<?= $material ?>"><?= $material ?></option>
        <?php endforeach; ?>
        </select>
        </div>
        <div class="form-group">
            <label for="manufacturer">Manufacturer:</label>
            <input type="text" class="form-control" id="manufacturer" name="manufacturer">
        </div>
        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="text" class="form-control" id="quantity" name="quantity">
        </div>
        <div class="form-group">
            <label for="sizes">Sizes:</label>
            <input type="text" class="form-control" id="sizes" name="sizes">
        </div>
        <br>
        <div class="form-group">
            <label for="image">Choose Image:</label>
            <input type="file" class="form-control-file" id="image" name="image" onchange="previewImage(event)">
        </div>
        <div class="form-group">
            <img id="imagePreview" src="#" alt="Preview" style="max-width: 200px; max-height: 200px;">
        </div>
        <br>
        <button type="submit" class="btn btn-black">Submit</button>
    </form>
</div>

<?php if (!empty($accessory)) : ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var accessory = <?php echo json_encode($accessory); ?>;
            document.getElementById('name').value = accessory.title;
            document.getElementById('description').value = accessory.description;
            document.getElementById('short_description').value = accessory.short_description;
            document.getElementById('price').value = accessory.price;
            document.getElementById('category').value = accessory.category;
            document.getElementById('color').value = accessory.color;
            document.getElementById('sizes').value = accessory.sizes;
            document.getElementById('manufacturer').value = accessory.manufacturer;
            document.getElementById('material').value = accessory.material;
            document.getElementById('quantity').value = accessory.quantity;
              
            if (accessory.image) {
                var imagePreview = document.getElementById('imagePreview');
                imagePreview.src =  accessory.image;
                imagePreview.style.display = 'block';

            }

            var idField = document.createElement('input');
            idField.setAttribute('type', 'hidden');
            idField.setAttribute('name', 'id');
            idField.setAttribute('value', accessory.id);
            document.getElementById('accessoryForm').appendChild(idField);
        });
    </script>
<?php endif; ?>

<script>

    function previewImage(event) {
        var image = document.getElementById('imagePreview');
        if (event.target.files && event.target.files[0]) {
            image.style.display = 'block';
            image.src = URL.createObjectURL(event.target.files[0]);
        } else {
            image.style.display = 'none'; 
        }
    }
</script>