<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<!-- Admin view: edit existing court -->
<h2>Editar pista</h2>

<!-- Court edit form -->
<form method="post"
      class="card card-body col-md-8"
      enctype="multipart/form-data">

    <!-- Court name field -->
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text"
               name="name"
               class="form-control"
               value="<?= htmlspecialchars($court['name']) ?>"
               required>
    </div>

    <!-- Court description field -->
    <div class="mb-3">
        <label class="form-label">Descripción</label>
        <textarea name="description"
                  class="form-control"><?= htmlspecialchars($court['description']) ?></textarea>
    </div>

    <!-- Court capacity field -->
    <div class="mb-3">
        <label class="form-label">Capacidad</label>
        <input type="number"
               name="max_players"
               class="form-control"
               min="1"
               value="<?= $court['max_players'] ?>"
               required>
    </div>

    <!-- Optional court image upload -->
    <div class="mb-3">
        <label class="form-label">Imagen de la pista</label>
        <input type="file" name="image" class="form-control">
    </div>

    <!-- Submit button -->
    <button class="btn btn-success">
        Guardar cambios
    </button>

    <!-- Back to court list -->
    <a class="btn btn-secondary mt-2"
       href="<?= APP_URL ?>?controller=court&action=index">
        Volver
    </a>

</form>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>

