

<!doctype html>
<html lang="fr">
    <?php require "Head.php"?>
<body>

<section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card text-white bg-primary mb-3" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <div class="mb-md-5 mt-md-4 pb-5">

              <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
              <p class="text-white-50 mb-5">Please enter your login and password!</p>
              <form id="Login" method="post" action="/login/login">
                <div class="form-outline form-white mb-4">
                  <input type="text" id="identifiant" name="identifiant" class="form-control form-control-lg" />
                  <label class="form-label">Identifiant</label>
                </div>

                <div class="form-outline form-white mb-4">
                  <input type="password" id="password" name="password" class="form-control form-control-lg" />
                  <label class="form-label">Password</label>
                </div>

                <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
              </form>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>
<style>

    .vh-100{
        margin-left:15%;
        margin-right:15%;
        margin-top:5%;
    }

</style>