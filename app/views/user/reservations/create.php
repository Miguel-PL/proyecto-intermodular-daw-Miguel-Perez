<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<!-- User/Admin view: create new reservation -->
<h2 class="mb-3">Nueva reserva</h2>

<!-- Breadcrumb navigation -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= APP_URL ?>">Inicio</a>
        </li>
        <li class="breadcrumb-item">
            <a href="<?= APP_URL ?>?controller=user&action=dashboard">Mi panel</a>
        </li>
        <li class="breadcrumb-item">
            <a href="<?= APP_URL ?>?controller=reservation&action=index">Mis reservas</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            Nueva reserva
        </li>
    </ol>
</nav>

<!-- Server-side error message -->
<?php if ($error): ?>
    <p style="color:red"><?= $error ?></p>
<?php endif; ?>

<!-- Reservation creation form -->
<form method="post"
    class="card card-body col-md-10"
    onsubmit="return document.getElementById('startDatetime').value !== ''">

    <?php
    // Check if current user is admin
    $isAdmin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    ?>

    <?php if ($isAdmin): ?>
        <!-- User selector (admin only) -->
        <div class="mb-3">
            <label class="form-label">Usuario</label>
            <select name="user_id" class="form-select" required>
                <?php foreach ($users as $u): ?>
                    <option value="<?= $u['id'] ?>">
                        <?= htmlspecialchars($u['full_name']) ?> (<?= $u['email'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    <?php endif; ?>

    <!-- Court selector -->
    <div class="mb-3">
        <label class="form-label">Pista</label>
        <select name="court_id" class="form-select" required>
            <option value="">Selecciona una pista</option>
            <?php foreach ($courts as $court): ?>
                <option value="<?= $court['id'] ?>">
                    <?= htmlspecialchars($court['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Calendar navigation -->
    <div class="d-flex justify-content-between align-items-center mb-2">
        <button type="button" id="prevMonth" class="btn btn-sm btn-outline-secondary">
            ◀ Mes anterior
        </button>

        <h5 id="calendarTitle" class="mb-0"></h5>

        <button type="button" id="nextMonth" class="btn btn-sm btn-outline-secondary">
            Mes siguiente ▶
        </button>
    </div>

    <!-- Dynamic calendar container -->
    <div id="calendarContainer" class="mb-4"></div>

    <!-- Available time slots -->
    <div id="timeSlots" style="display:none;">
        <h5>Horarios disponibles</h5>
        <div id="slotsContainer" class="d-flex flex-wrap gap-2 mb-3"></div>
    </div>

    <!-- Reservation duration -->
    <div class="mb-3">
        <label class="form-label">Duración</label>
        <select name="duration_minutes" class="form-select" required>
            <option value="90">1 hora y 30 minutos</option>
            <option value="180">3 horas</option>
        </select>
    </div>

    <!-- Selected datetime (filled by JavaScript) -->
    <input type="hidden" name="start_datetime" id="startDatetime">

    <!-- Submit reservation -->
    <button type="submit" class="btn btn-success">
        Confirmar reserva
    </button>
</form>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>
