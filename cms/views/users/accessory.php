<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $this->Title; ?></title>
    <style>
        .btn-black {
            background-color: black;
            color: white;
        }

        .btn-black:hover {
            background-color: #333;
        }

        .add-accessory-btn {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light">Accessory</h1>
                <br>
           
                <form class="w-100" role="search">
                    <div class="input-group"> 
                        <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
                        <button type="submit" class="btn btn-black">Search</button>
                    </div>
                </form>
                </p>
                <button class="btn btn-black add-accessory-btn">Додати товар</button>
            </div>            
        </div>
    </section>
    <div class="album py-5 bg-body-tertiary">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3" id="accessoryRow">
                <!-- Здесь будут отображаться товары -->
            </div>
        </div>
    </div>

    <script>
        var accessories = <?php echo json_encode($accessories); ?>;
        console.log(accessories.length);

        accessories.forEach(function(accessory) {
            var card = document.createElement('div');
            card.className = 'col';
            card.innerHTML = `
                <div class="card shadow-sm">
                    <img src="${accessory.image}" class="bd-placeholder-img card-img-top" width="100%" height="225" aria-label="Placeholder: ${accessory.title}" preserveAspectRatio="xMidYMid slice" focusable="false">
                    <div class="card-body">
                        <h5 class="card-title">${accessory.title}</h5>
                        <p class="card-text">${accessory.short_description}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-secondary">Details</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary">Delete</button>
                            </div>
                            <small class="text-muted">Price: ${accessory.price}$</small>
                        </div>
                    </div>
                </div>
            `;
            document.getElementById('accessoryRow').appendChild(card);
        });

        document.querySelector('.add-accessory-btn').addEventListener('click', function() {
        window.location.href = 'addAccessory';
            console.log('Додати товар');
        });
    </script>
</body>
</html>
