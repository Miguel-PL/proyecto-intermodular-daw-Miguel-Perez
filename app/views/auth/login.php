<?php require_once __DIR__ . '/../partials/header.php'; ?>

<!-- Login view -->
<h2 class="mb-4">Login</h2>

<!-- Display authentication error message -->
<?php if (!empty($error)): ?>
    <div class="alert alert-danger">
        <?= $error ?>
    </div>
<?php endif; ?>

<!-- Login form -->
<form method="post" class="card card-body col-md-6 mx-auto">

    <!-- Email input -->
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email"
               name="email"
               class="form-control"
               required>
    </div>

    <!-- Password input -->
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password"
               name="password"
               class="form-control"
               required>
    </div>

    <!-- Submit login -->
    <button class="btn btn-success w-100">
        Login
    </button>

</form>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>


