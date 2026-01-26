<?php require_once __DIR__ . '/../partials/header.php'; ?>

<!-- User view: change password -->
<h2 class="mb-3">Cambiar contraseña</h2>

<!-- Password update form -->
<form method="post"
      action="<?= APP_URL ?>?controller=user&action=updatePassword"
      class="card card-body col-md-6">

    <!-- Current password input -->
    <div class="mb-3">
        <label class="form-label">Contraseña actual</label>
        <input type="password" name="current_password"
               class="form-control" required>
    </div>

    <!-- New password input -->
    <div class="mb-3">
        <label class="form-label">Nueva contraseña</label>
        <input type="password" name="new_password"
               class="form-control" required>
    </div>

    <!-- Confirm new password -->
    <div class="mb-3">
        <label class="form-label">Confirmar nueva contraseña</label>
        <input type="password" name="confirm_password"
               class="form-control" required>
    </div>

    <!-- Form action buttons -->
    <div class="d-flex justify-content-end gap-2">
        <button type="submit" class="btn btn-success">
            Guardar
        </button>

        <a href="<?= APP_URL ?>?controller=user&action=dashboard"
           class="btn btn-secondary">
            Cancelar
        </a>
    </div>
</form>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>

