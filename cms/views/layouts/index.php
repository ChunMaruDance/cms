<?php

/** @var string $Title */
/** @var string $Content */

use \models\Users;

if(empty($Title)){
  $Title = '';
}

if(empty($Content)){
  $Content = '';
}

if(empty($basketItemCount)){
  $basketItemCount = 0;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title> <?=$Title?></title>
    <link rel="stylesheet" type="text/css" href="/css/header.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <div class="container">
    <a class="navbar-brand" href="/">Shop Accessory</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item active">
          <a class="nav-link" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/products/order">Cart <span id="basketItemCount"><?php echo $basketItemCount > 0 ? $basketItemCount: ''; ?></span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/reviews/contact">Contact</a>
        </li>

        <?php if (Users::isUserLogged()) : ?>
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
      Panel
    </a>
    <ul class="dropdown-menu" aria-labelledby="userMenu">
      <li><a class="dropdown-item" href="/users/login">Dashboard</a></li>
      <li><a class="dropdown-item" href="/users/addAccessory">Create Accessory</a></li>
      <li><a class="dropdown-item" href="/users/addCategory">Create Category</a></li>
      <li><hr class="dropdown-divider"></li>
      <li><a class="dropdown-item" href="/users/logout">Sign out</a></li>
    </ul>
  </li>
<?php else: ?>
  <li class="nav-item">
    <a class="nav-link" href="/users/login">Sign in</a>
  </li>
<?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<section class="py-5">
  <div>
    <?=$Content?>
  </div>
</section>


  <div class="container">
  <footer class="py-3 my-4">
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Home</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Features</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Pricing</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">FAQs</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">About</a></li>
    </ul>
    <p class="text-center text-body-secondary">© 2024 Company, Inc</p>
  </footer>
  </div>

</body>
</html>