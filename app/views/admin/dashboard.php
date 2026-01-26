<?php require_once __DIR__ . '/../partials/header.php'; ?>

<!-- Admin dashboard -->
<h2 class="mb-3">Panel de administración</h2>

<!-- Breadcrumb navigation -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= APP_URL ?>">Inicio</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            Administración
        </li>
    </ol>
</nav>

<!-- Admin main actions -->
<div class="row g-4">

    <!-- Reservation management -->
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Reservas</h5>
                <p class="card-text text-muted">
                    Ver, filtrar y cancelar reservas de todos los usuarios.
                </p>

                <div class="mt-auto">
                    <a href="<?= APP_URL ?>?controller=adminReservation&action=index"
                        class="btn btn-success w-100">
                        Gestionar reservas
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Court management -->
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Pistas</h5>
                <p class="card-text text-muted">
                    Alta, edición y eliminación de pistas del club.
                </p>

                <div class="mt-auto">
                    <a href="<?= APP_URL ?>?controller=court&action=index"
                        class="btn btn-primary w-100">
                        Gestionar pistas
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- User management -->
    <div class="col-md-4">
        <div class="card shadow-sm h-100 border-secondary">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Usuarios</h5>
                <p class="card-text text-muted">
                    Gestión de usuarios y roles.
                </p>

                <div class="mt-auto">
                    <a href="<?= APP_URL ?>?controller=adminUser&action=index"
                        class="btn btn-secondary w-100">
                        Gestionar usuarios
                    </a>
                </div>

            </div>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
