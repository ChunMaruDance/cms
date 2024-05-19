<style>
    .btn-black {
        background-color: black;
        color: white;
    }

    .btn-black:hover {
        background-color: #333;
    }

    .add-category-btn {
        margin-bottom: 20px;
    }

    .category-card {
        background-color: #fff;
        border-radius: 10px; 
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1);
        transition: all 0.2s ease-in-out;
        cursor: pointer;
        width: 18%;
        margin: 1%;
    }

    .category-card:hover {
        transform: translateY(-5px);
        background-color: #f5f5f5; 
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2); 
    }

    .category-image {
        width: 100%;
        height: auto;
        border-radius: 10px 10px 0 0;
    }

    .category-name {
        font-size: 16px;
        font-weight: bold;
        margin: 10px 0;
    }
</style>
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
                <span class="category-name">${category.title}</span>
            `;
         
            card.addEventListener('click', function() {
                window.location.href = '/users/addCategory/' + category.id;
            });
            categoryRow.appendChild(card);
        });
    }
    renderCategories(categories);

    document.querySelector('.add-category-btn').addEventListener('click', function() {
        window.location.href = 'addCategory';
    });
</script>