<footer class="mt-5 footer text-center text-white" style="background-color: #674232;">
  <!-- <div class="text-center p-3" style="background-color: #674232;">
    <p class="d-flex justify-content-center align-items-center">
      <span class="me-3">Contactez-nous</span>
      <button type="button" class="btn btn-outline-light btn-rounded">Contact</button>
    </p>
    © 2021 Copyright :
    <a class="text-white" href="index.php">SPS</a>
  </div> -->
  <script src="/QuickBaluchon/QuickBaluchon/js/footerForm.js" defer></script>
  <?php if (isset($_SESSION['user'])) { ?>
  <div class="pt-3 row">
  <p class="justify-content-center align-items-center">
    <span class="me-3"><?php echo $site->footer->contact->title; ?></span>
    <a href="/QuickBaluchon/QuickBaluchon/contact.php"><button type="button" class="btn btn-outline-light btn-rounded"><?php echo $site->footer->contact->buttonName; ?></button></a>
  </p>
  </div>
  <div class="row">
    <p class="justify-content-center align-items-center">
      <?php echo $site->footer->copyright->title; ?>
      <a class="text-white" href="index.php"><?php echo $site->footer->copyright->linkName; ?></a>
    </p>
  </div>
  <?php } else { ?>
  <div class="pt-3 row justify-content-around">
    <div class="col-lg-4">
      <p class="justify-content-center align-items-center">
        <span class="me-3"><?php echo $site->footer->contact->title; ?></span>
        <a href="/QuickBaluchon/QuickBaluchon/contact.php"><button type="button" class="btn btn-outline-light btn-rounded"><?php echo $site->footer->contact->buttonName; ?></button></a>
      </p>
    </div>
    <div class="col-lg-4 mb-2 mb-lg-0">
      <!-- <p class="justify-content-center align-items-center">
        <span class="me-3">Connexion Staff</span>
        <a href="login_staff.php"><button type="button" class="btn btn-outline-light btn-rounded">Connexion</button></a>
      </p> -->
      <div class="dropup">
        <a aria-expanded="false" data-bs-toggle="dropdown" class="btn btn-outline-light me-2 dropdown-toggle" href="#"><?php echo $site->footer->staffLogIn->buttonName; ?></a>
        <div class="dropdown-menu" id="dropMenu">
        <?php if (isset($_GET['ifail'])) {
            echo "<h3 class='text-warning'>" . $_GET['ifail'] . "</h3>";
        } ?>
          <form class="px-4 py-3 needs-validation" action="actions/login_form.php" method="POST" novalidate>
            <!-- Username input -->
            <div class="form-outline mb-4">
              <input type="text" name="username" class="form-control" aria-label="e-mail address" required>
              <label class="form-label" for="form2Example1"><?php echo $site->footer->staffLogIn->form->usernameInput->title; ?></label>
              <div class="valid-feedback"><?php echo $site->footer->staffLogIn->form->usernameInput->valid; ?></div>
              <div class="invalid-feedback"><?php echo $site->footer->staffLogIn->form->usernameInput->invalid; ?></div>
            </div>
            <!-- Password input -->
            <div class="form-outline mb-4">
              <input type="password" name="password" class="form-control" aria-label="Votre mot de passe" required>
              <label class="form-label" for="form2Example2"><?php echo $site->footer->staffLogIn->form->passwordInput->title; ?></label>
              <div class="valid-feedback"><?php echo $site->footer->staffLogIn->form->passwordInput->valid; ?></div>
              <div class="invalid-feedback"><?php echo $site->footer->staffLogIn->form->passwordInput->invalid; ?></div>
            </div>
            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-block"><?php echo $site->footer->staffLogIn->form->validation; ?></button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <p class="justify-content-center align-items-center">
      <?php echo $site->footer->copyright->title; ?>
      <a class="text-white" href="index.php"><?php echo $site->footer->copyright->linkName; ?></a>
    </p>
  </div>
  <?php } ?>
  <!-- Copyright -->
</footer>
<script 
  src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" 
  integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" 
  crossorigin="anonymous">
</script>
<script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" 
  integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" 
  crossorigin="anonymous">
</script>
<script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" 
  integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" 
  crossorigin="anonymous">
</script>