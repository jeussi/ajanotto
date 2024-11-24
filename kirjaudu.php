<?php
include_once 'inc/header.php';
?>

<div class="container">
  <div class="row">
    <div class="col-8 mx-auto">
      <div class="card card-body bg-light mt-3">
        <h2>Kirjaudu sisään</h2>
        <form method="post">
          <div class="mb-3">
            <label for="kayttajanimi" class="form-label">Käyttäjätunnus</label>
            <input type="text" class="form-control" id="kayttajanimi" name="kayttajanimi" required>
          </div>
          <div class="mb-3">
            <label for="salasana" class="form-label">Salasana</label>
            <input type="password" class="form-control" id="salasana" name="salasana" required>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-success">Kirjaudu</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include_once 'inc/footer.php'; ?>