<style>
#categoryFormContainer {
    max-width: 600px;
    margin: 0 auto;
}

#categoryFormContainer .btn-black {
    background-color: black;
    color: white;
}

#categoryFormContainer .btn-black:hover {
    background-color: #333;
}


</style>

<div id="categoryFormContainer" class="container mt-5">
    <h2 class="mb-4">Create New Category</h2>
    <?php if (!empty($error_message)) : ?>
        <div class="alert alert-danger">
            <strong>Error : </strong><?= $error_message ?>
        </div>
    <?php endif; ?>
    <form id="categoryForm" action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description"></textarea>
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

<?php if (!empty($category)) : ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var category = <?php echo json_encode($category); ?>;
            document.getElementById('name').value = category.title;
            document.getElementById('description').value = category.description;

            if (category.image) {
                var imagePreview = document.getElementById('imagePreview');
                imagePreview.src =  category.image;
                imagePreview.style.display = 'block';

            }

            var idField = document.createElement('input');
            idField.setAttribute('type', 'hidden');
            idField.setAttribute('name', 'id');
            idField.setAttribute('value', category.id);
            document.getElementById('categoryForm').appendChild(idField);
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