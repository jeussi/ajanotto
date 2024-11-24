<?php
include_once 'inc/header.php';
?>

<div class="container">
  <div class="row">
    <div class="col-8 mx-auto">
      <div class="card card-body bg-light mt-3">
        <h2>Lisää joukkue</h2>
        <form method="post">
          <div class="mb-3">
            <label for="nimi" class="form-label">Joukkueen nimi</label>
            <input type="text" class="form-control" id="nimi" name="nimi" required>
          </div>
          <div class="mb-3">
            <label for="koulu" class="form-label">Koulu</label>
            <input type="text" class="form-control" id="koulu" name="koulu" required>
          </div>
          <div class="mb-3">
            <label for="jasen1" class="form-label">Jäsen 1</label>
            <input type="text" class="form-control" id="jasen1" name="jasen1" required>
          </div>
          <div class="mb-3">
            <label for="jasen2" class="form-label">Jäsen 2</label>
            <input type="text" class="form-control" id="jasen2" name="jasen2" required>
          </div>
          <div class="mb-3">
            <label for="jasen3" class="form-label">Jäsen 3</label>
            <input type="text" class="form-control" id="jasen3" name="jasen3" required>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-success">Tallenna</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include_once 'inc/footer.php'; ?>