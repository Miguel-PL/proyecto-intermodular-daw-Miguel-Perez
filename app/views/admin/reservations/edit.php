<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<!-- Admin view: edit reservation -->
<h2 class="mb-3">Editar reserva</h2>

<!-- Reservation edit form -->
<form method="post"
      action="<?= APP_URL ?>?controller=adminReservation&action=update"
      class="card card-body">

    <!-- Hidden reservation id -->
    <input type="hidden" name="id" value="<?= $reservation['id'] ?>">

    <!-- User selector -->
    <div class="mb-3">
        <label class="form-label">Usuario</label>
        <select name="user_id" class="form-select" required>
            <?php foreach ($users as $u): ?>
                <option value="<?= $u['id'] ?>"
                    <?= $u['id'] == $reservation['user_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($u['full_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Court selector -->
    <div class="mb-3">
        <label class="form-label">Pista</label>
        <select name="court_id" class="form-select" required>
            <?php foreach ($courts as $court): ?>
                <option value="<?= $court['id'] ?>"
                    <?= $court['id'] == $reservation['court_id'] ? 'selected' : '' ?>>
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

    <!-- Available time slots (loaded dynamically) -->
    <div id="timeSlots" style="display:none;">
        <h5>Horarios disponibles</h5>
        <div id="slotsContainer" class="d-flex flex-wrap gap-2 mb-3"></div>
    </div>

    <!-- Reservation duration selector -->
    <div class="mb-3">
        <label class="form-label">Duración</label>
        <select name="duration_minutes" class="form-select" required>
            <option value="90">1 hora y 30 minutos</option>
            <option value="180">3 horas</option>
        </select>
    </div>

    <!-- Selected start datetime (filled by JavaScript) -->
    <input type="hidden" name="start_datetime" id="startDatetime">

    <!-- Submit button -->
    <button type="submit" class="btn btn-success mt-3">
        Guardar cambios
    </button>

    <!-- Cancel action -->
    <a href="<?= APP_URL ?>?controller=adminReservation&action=index"
       class="btn btn-secondary mt-3">
        Cancelar
    </a>
</form>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>

