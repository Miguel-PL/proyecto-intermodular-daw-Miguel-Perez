<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<!-- Admin view: edit user -->
<h2 class="mb-3">Editar usuario</h2>

<!-- Breadcrumb navigation -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= APP_URL ?>">Inicio</a>
        </li>
        <li class="breadcrumb-item">
            <a href="<?= APP_URL ?>?controller=admin&action=dashboard">
                Administración
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="<?= APP_URL ?>?controller=adminUser&action=index">
                Usuarios
            </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            Editar
        </li>
    </ol>
</nav>

<!-- User edit form -->
<form method="post"
    action="<?= APP_URL ?>?controller=adminUser&action=update"
    class="card card-body col-md-6">

    <!-- Hidden user id -->
    <input type="hidden" name="id" value="<?= $user['id'] ?>">

    <!-- Full name field -->
    <div class="mb-3">
        <label class="form-label">Nombre completo</label>
        <input type="text"
            name="full_name"
            class="form-control"
            value="<?= htmlspecialchars($user['full_name']) ?>"
            required>
    </div>

    <!-- Email field -->
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email"
            name="email"
            class="form-control"
            value="<?= htmlspecialchars($user['email']) ?>"
            required>
    </div>

    <!-- Phone field -->
    <div class="mb-3">
        <label class="form-label">Teléfono</label>
        <input type="text"
            name="phone"
            class="form-control"
            value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
    </div>

    <!-- User level selector -->
    <div class="mb-3">
        <label class="form-label">Nivel de juego</label>
        <select name="level" class="form-select">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <option value="<?= $i ?>"
                    <?= ($user['level'] ?? 1) == $i ? 'selected' : '' ?>>
                    Nivel <?= $i ?>
                </option>
            <?php endfor; ?>
        </select>
    </div>

    <!-- Role selector -->
    <div class="mb-3">
        <label class="form-label">Rol</label>
        <select name="role_id" class="form-select">
            <?php foreach ($roles as $role): ?>
                <option value="<?= $role['id'] ?>"
                    <?= $role['id'] == $user['role_id'] ? 'selected' : '' ?>>
                    <?= ucfirst($role['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Active status checkbox -->
    <div class="form-check mb-3">
        <input class="form-check-input"
            type="checkbox"
            name="active"
            id="active"
            <?= $user['active'] ? 'checked' : '' ?>>
        <label class="form-check-label" for="active">
            Usuario activo
        </label>
    </div>

    <!-- Form action buttons -->
    <div class="d-flex gap-2 mt-3">
        <button type="submit" class="btn btn-success">
            Guardar cambios
        </button>

        <a href="<?= APP_URL ?>?controller=adminUser&action=index"
            class="btn btn-secondary">
            Cancelar
        </a>
    </div>

</form>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>
