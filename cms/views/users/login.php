      <style>
        .gradient-custom {
          background: #6a11cb;

          background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));
          background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
        }
        .card {
         width: 60%; 
        padding: 20px; 
        margin: auto;
        border-radius: 1rem;
        }
      </style>
<form method="post" action="">
      <div class="row d-flex justify-content-center align-items-center vh-100">
    <div class="col-12 col-md-6"> 
      <div class="card bg-dark text-white">

      <?php if (!empty($error_message)) : ?>
      <div class="alert alert-danger">
       <strong>Error : </strong><?= $error_message ?>
      </div>
      <?php endif; ?>
      
        <div class="card-body p-4 text-center">

          <div class="mb-md-4 mt-md-3 pb-4">

            <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
            <p class="text-white-50">Please enter your login and password!</p>

            <div class="form-outline form-white mb-3">
              <input type="email" id="inputEmail" class="form-control form-control-md" name="login">
              <label class="form-label" for="inputEmail">Login</label>
            </div>

            <div class="form-outline form-white mb-3">
              <input name="password" type="password" id ="inputPassword" class="form-control form-control-md">
              <label class="form-label" for="inputPassword">Password</label>
            </div>
            <button class="btn btn-outline-light btn-md px-4" type="submit">Login</button> 
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
     