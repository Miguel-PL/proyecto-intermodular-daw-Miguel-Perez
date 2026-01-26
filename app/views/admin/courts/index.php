<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<!-- Admin view: court management list -->
<h2 class="mb-3">Gestión de pistas</h2>

<!-- Breadcrumb navigation -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= APP_URL ?>">Inicio</a>
        </li>
        <li class="breadcrumb-item">
            <a href="<?= APP_URL ?>?controller=admin&action=dashboard">Administración</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            Pistas
        </li>
    </ol>
</nav>

<!-- Header actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">
        Gestión de las pistas disponibles en el club.
    </p>

    <!-- Create new court button -->
    <a href="<?= APP_URL ?>?controller=court&action=create"
       class="btn btn-success">
        ➕ Nueva pista
    </a>
</div>

<!-- Empty state message -->
<?php if (empty($courts)): ?>
    <div class="alert alert-info">
        No hay pistas registradas.
    </div>
<?php else: ?>

<!-- Court cards grid -->
<div class="row g-4">

<?php foreach ($courts as $court): ?>
    <div class="col-md-4">
        <div class="card shadow-sm h-100">

            <!-- Court image (fallback placeholder) -->
            <img src="<?= APP_URL ?>/assets/images/courts/<?= $court['image'] ?? 'image_corp.png' ?>"
                 class="card-img-top"
                 alt="Pista">

            <div class="card-body d-flex flex-column">
                <!-- Court name -->
                <h5 class="card-title">
                    <?= htmlspecialchars($court['name']) ?>
                </h5>

                <!-- Court description -->
                <p class="card-text text-muted">
                    <?= htmlspecialchars($court['description']) ?>
                </p>

                <!-- Court capacity -->
                <p class="card-text small">
                    <strong>Capacidad:</strong>
                    <?= $court['max_players'] ?> jugadores
                </p>

                <!-- Action buttons -->
                <div class="mt-auto d-flex gap-2">
                    <a href="<?= APP_URL ?>?controller=court&action=edit&id=<?= $court['id'] ?>"
                       class="btn btn-sm btn-primary w-100">
                        Editar
                    </a>

                    <a href="<?= APP_URL ?>?controller=court&action=delete&id=<?= $court['id'] ?>"
                       class="btn btn-sm btn-outline-danger w-100"
                       onclick="return confirm('¿Eliminar esta pista?')">
                        Eliminar
                    </a>
                </div>
            </div>

        </div>
    </div>
<?php endforeach; ?>

</div>
<?php endif; ?>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>

