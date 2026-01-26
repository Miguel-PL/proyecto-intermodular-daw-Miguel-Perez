<?php require_once __DIR__ . '/../partials/header.php'; ?>

<!-- User dashboard -->
<h2 class="mb-3">Mi panel</h2>

<div class="d-flex justify-content-between align-items-center mb-4">

    <!-- Breadcrumb navigation -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="<?= APP_URL ?>">Inicio</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Mi panel
            </li>
        </ol>
    </nav>

    <!-- Change password action -->
    <a href="<?= APP_URL ?>?controller=user&action=changePassword"
        class="btn btn-outline-secondary">
        Cambiar contraseña
    </a>

</div>

<!-- User main actions -->
<div class="row g-4">

    <!-- Card: User reservations -->
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Mis reservas</h5>
                <p class="card-text text-muted">
                    Consulta y gestiona tus reservas activas y pasadas.
                </p>

                <div class="mt-auto">
                    <a href="<?= APP_URL ?>?controller=reservation&action=index"
                        class="btn btn-success w-100">
                        Ver mis reservas
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Card: Create new reservation -->
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Nueva reserva</h5>
                <p class="card-text text-muted">
                    Reserva una pista disponible en el horario que prefieras.
                </p>

                <div class="mt-auto">
                    <a href="<?= APP_URL ?>?controller=reservation&action=create"
                        class="btn btn-primary w-100">
                        Crear reserva
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
