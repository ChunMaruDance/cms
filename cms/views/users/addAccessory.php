<style>
#accessoryFormContainer {
    max-width: 600px; 
    margin: 0 auto;
}

#accessoryFormContainer .btn-black {
    background-color: black;
    color: white;
}

#accessoryFormContainer .btn-black:hover {
    background-color: #333;
}

#imagePreview {
    display: none;
}

#category {
    color: black; 
}

#category {
    color: black;
}

</style>

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
        <br>
        <div class="form-group">
            <label for="category">Category:</label>
            <br>
            <select class="form-control" id="category" name="category">
                <?php foreach ($categories as $category) : ?>
                    <option value="<?= $category->title ?>"><?= $category->title ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <br>
        <div class="form-group">
            <label for="image">Choose Image:</label>
            <input type="file" class="form-control-file" id="image" name="image" onchange="previewImage(event)">
        </div>
        <br>
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

            if (accessory.image) {
                var imagePreview = document.getElementById('imagePreview');
                imagePreview.src =  accessory.image;
                imagePreview.style.display = 'block';
            }

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