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
</style>
<section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light">Categories</h1>
                <br>
                <button class="btn btn-black add-category-btn">Додати категорію</button>
            </div>            
        </div>
    </section>
    <div class="album py-5 bg-body-tertiary">
        <div class="container">
            <div class="row justify-content-center" id="categoryRow">
                <!-- Categories will be displayed here -->
            </div>
        </div>
    </div>
    <script>
    var categories = <?php echo json_encode($categories); ?>;

    // Function to render categories
    function renderCategories(categories) {
        var categoryRow = document.getElementById('categoryRow');
        categories.forEach(function(category) {
            var card = document.createElement('div');
            card.className = 'category-card d-flex flex-column align-items-center text-center p-3';
            card.innerHTML = `
                <img src="${category.image}" alt="${category.name}" class="category-image mb-2">
                <span class="category-name">${category.name}</span>
            `;
            // Add event listener to navigate to category page
            card.addEventListener('click', function() {
                window.location.href = '/products/category/' + category.id;
            });
            categoryRow.appendChild(card);
        });
    }

    // Call renderCategories function to display categories
    renderCategories(categories);

    // Add event listener to "Add Category" button
    document.querySelector('.add-category-btn').addEventListener('click', function() {
        window.location.href = 'addCategory';
    });
    </script>