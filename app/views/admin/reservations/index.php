<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<!-- Admin view: reservation management list -->
<h2 class="mb-3">Gestión de reservas</h2>

<!-- Header with breadcrumb and create action -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= APP_URL ?>">Inicio</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= APP_URL ?>?controller=admin&action=dashboard">Administración</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Reservas
            </li>
        </ol>
    </nav>

    <!-- Create new reservation button -->
    <a href="<?= APP_URL ?>?controller=reservation&action=create"
        class="btn btn-primary">
        Nueva reserva
    </a>
</div>

<!-- Empty state message -->
<?php if (empty($reservations)): ?>
    <div class="alert alert-info">
        No hay reservas registradas.
    </div>
<?php else: ?>

    <!-- Reservation cards list -->
    <div class="row g-4">

        <?php foreach ($reservations as $r): ?>
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="row g-0 align-items-center">

                        <!-- Reservation information -->
                        <div class="col-md-9">
                            <div class="card-body">
                                <!-- Court name -->
                                <h5 class="card-title mb-1">
                                    <?= htmlspecialchars($r['court_name']) ?>
                                </h5>

                                <!-- User name -->
                                <p class="card-text mb-1">
                                    <strong>Usuario:</strong>
                                    <?= htmlspecialchars($r['user_name']) ?>
                                </p>

                                <!-- Date, time and duration -->
                                <p class="card-text mb-1">
                                    <strong>Fecha:</strong>
                                    <?= date('d/m/Y', strtotime($r['start_datetime'])) ?>
                                    &nbsp;
                                    <strong>Hora:</strong>
                                    <?= date('H:i', strtotime($r['start_datetime'])) ?>
                                    &nbsp;
                                    <strong>Duración:</strong>
                                    <?= $r['duration_minutes'] ?> minutos.
                                </p>

                                <!-- Reservation status -->
                                <p class="card-text small text-muted">
                                    Estado:
                                    <?php if ($r['status'] === 'confirmed'): ?>
                                        <span class="badge bg-success">Confirmada</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Cancelada</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>

                        <!-- Action buttons -->
                        <div class="col-md-3 text-end pe-3">
                            <div class="d-flex flex-column gap-2 py-3">

                                <?php if ($r['status'] === 'confirmed'): ?>

                                    <!-- Edit reservation -->
                                    <a href="<?= APP_URL ?>?controller=adminReservation&action=edit&id=<?= $r['id'] ?>"
                                        class="btn btn-sm btn-outline-primary">
                                        Editar
                                    </a>

                                    <!-- Cancel reservation -->
                                    <a href="<?= APP_URL ?>?controller=adminReservation&action=cancel&id=<?= $r['id'] ?>"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('¿Cancelar esta reserva?')">
                                        Cancelar
                                    </a>
                                <?php else: ?>
                                    <!-- No actions for canceled reservations -->
                                    <span class="badge bg-light text-muted">
                                        Sin acciones
                                    </span>
                                <?php endif; ?>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>
