<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<!-- User view: reservation list -->
<h2 class="mb-3">Mis reservas</h2>

<div class="d-flex justify-content-between align-items-center mb-4">
    <!-- Breadcrumb navigation -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= APP_URL ?>">Inicio</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= APP_URL ?>?controller=user&action=dashboard">Mi panel</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Mis reservas
            </li>
        </ol>
    </nav>

    <!-- Create new reservation -->
    <a href="<?= APP_URL ?>?controller=reservation&action=create"
       class="btn btn-success">
        ➕ Nueva reserva
    </a>
</div>

<div class="table-responsive">
    <!-- Empty state -->
    <?php if (empty($reservations)): ?>
        <div class="alert alert-info">
            No tienes reservas todavía.
        </div>
    <?php else: ?>

    <!-- Reservation cards -->
    <div class="row g-3">

    <?php foreach ($reservations as $r): ?>
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="row g-0 align-items-center">

                    <!-- Reservation information -->
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title mb-1">
                                <?= htmlspecialchars($r['court_name']) ?>
                            </h5>

                            <p class="card-text mb-1">
                                <strong>Fecha:</strong>
                                <?= date('d/m/Y', strtotime($r['start_datetime'])) ?>
                                &nbsp;
                                <strong>Hora:</strong>
                                <?= date('H:i', strtotime($r['start_datetime'])) ?>
                            </p>

                            <p class="card-text small text-muted">
                                Duración: <?= $r['duration_minutes'] ?> minutos.
                            </p>
                        </div>
                    </div>

                    <!-- Reservation actions -->
                    <div class="col-md-2 text-end pe-3">
                        <div class="d-flex flex-column gap-2 py-3">

                            <?php
                            // Check if reservation can be canceled (2 hours rule)
                            $canCancel = false;
                            if ($r['status'] === 'confirmed') {
                                $start = new DateTime($r['start_datetime']);
                                $now = new DateTime();
                                $canCancel = (($start->getTimestamp() - $now->getTimestamp()) / 3600) >= 2;
                            }
                            ?>

                            <?php if ($canCancel): ?>
                                <!-- Cancel reservation -->
                                <a href="<?= APP_URL ?>?controller=reservation&action=cancel&id=<?= $r['id'] ?>"
                                class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('¿Cancelar esta reserva?')">
                                    Cancelar
                                </a>
                            <?php else: ?>
                                <!-- Not cancelable / canceled -->
                                <span class="badge bg-secondary">
                                    Cancelada
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
</div>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>

