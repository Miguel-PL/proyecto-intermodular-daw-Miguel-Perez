<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<!-- Admin view: create new user -->
<h2 class="mb-3">Nuevo usuario</h2>

<!-- User creation form -->
<form method="post"
    action="<?= APP_URL ?>?controller=adminUser&action=store"
    class="card card-body col-md-6">

    <!-- Full name input -->
    <div class="mb-3">
        <label class="form-label">Nombre completo</label>
        <input type="text" name="full_name" class="form-control" required>
    </div>

    <!-- Email input -->
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <!-- Phone number input -->
    <div class="mb-3">
        <label class="form-label">Teléfono</label>
        <input type="text"
            name="phone"
            class="form-control">
    </div>

    <!-- User skill level selector -->
    <div class="mb-3">
        <label class="form-label">Nivel de juego</label>
        <select name="level" class="form-select">
            <option value="1">Nivel 1 - Principiante</option>
            <option value="2">Nivel 2 - Básico</option>
            <option value="3">Nivel 3 - Intermedio</option>
            <option value="4">Nivel 4 - Alto</option>
            <option value="5">Nivel 5 - Experto</option>
        </select>
    </div>

    <!-- Role selector -->
    <div class="mb-3">
        <label class="form-label">Rol</label>
        <select name="role_id" class="form-select">
            <?php foreach ($roles as $role): ?>
                <option value="<?= $role['id'] ?>">
                    <?= ucfirst($role['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Active status checkbox -->
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="active" checked>
        <label class="form-check-label">
            Usuario activo
        </label>
    </div>

    <!-- Form action buttons -->
    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-success">
            Crear usuario
        </button>

        <a href="<?= APP_URL ?>?controller=adminUser&action=index"
            class="btn btn-secondary">
            Cancelar
        </a>
    </div>
</form>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>
