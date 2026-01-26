<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<!-- Admin view: create new court -->
<h2>Nueva pista</h2>

<!-- Court creation form -->
<form method="post"
      class="card card-body col-md-8"
      enctype="multipart/form-data">

    <!-- Court name input -->
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text"
               name="name"
               class="form-control"
               required>
    </div>

    <!-- Court description textarea -->
    <div class="mb-3">
        <label class="form-label">Descripción</label>
        <textarea name="description"
                  class="form-control"></textarea>
    </div>

    <!-- Maximum players allowed -->
    <div class="mb-3">
        <label class="form-label">Capacidad</label>
        <input type="number"
               name="max_players"
               class="form-control"
               min="1"
               value="4"
               required>
    </div>

    <!-- Court image upload -->
    <div class="mb-3">
        <label class="form-label">Imagen de la pista</label>
        <input type="file" name="image" class="form-control">
    </div>

    <!-- Submit button -->
    <button class="btn btn-success">
        Guardar
    </button>

    <!-- Cancel and return to court list -->
    <a class="btn btn-secondary mt-2"
       href="<?= APP_URL ?>?controller=court&action=index">
        Cancelar
    </a>

</form>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>

