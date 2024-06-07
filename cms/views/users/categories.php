<?php
$this->Title = 'Категорії';
?>
<head>
  <link rel="stylesheet" href="/css/categoriesPage.css">
</head>
<section class="py-5 text-center container">
    <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
            <h1 class="fw-light">Категорії</h1>
            <br>
            <button class="btn btn-black add-category-btn">Додати категорію</button>
        </div>            
    </div>
</section>

<div class="album py-5 bg-body-tertiary">
    <div class="container">
        <div class="row justify-content-center" id="categoryRow">
            <!-- Категорії будуть відображені тут -->
        </div>
    </div>
</div>

<script>
   var categories = <?php echo json_encode($categories); ?>;

function renderCategories(categories) {
    var categoryRow = document.getElementById('categoryRow');
    categories.forEach(function(category) {
        var card = document.createElement('div');
        card.className = 'category-card d-flex flex-column align-items-center text-center p-3';
        card.innerHTML = `
            <img src="${category.image}" alt="${category.title}" class="category-image">
            <div class="category-info">
                <span class="category-name">${category.title}</span>
                <button class="delete-btn" data-category-id="${category.id}">Delete</button>
            </div>
        `;

        card.addEventListener('click', function() {
            window.location.href = '/users/addCategory/' + category.id;
        });

        var deleteBtn = card.querySelector('.delete-btn');
        deleteBtn.addEventListener('click', function(event) {
            event.stopPropagation();
            var categoryId = this.dataset.categoryId;
            deleteCategory(categoryId);
        });

        categoryRow.appendChild(card);
    });
}

function deleteCategory(categoryId) {
    fetch('deleteCategory', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ category_id: categoryId })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log(data); 
        location.reload(); 
    })
    .catch(error => {
        console.error('There was an error!', error);
    });
}

renderCategories(categories);

document.querySelector('.add-category-btn').addEventListener('click', function() {
    window.location.href = 'addCategory';
});
</script>
