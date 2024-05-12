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