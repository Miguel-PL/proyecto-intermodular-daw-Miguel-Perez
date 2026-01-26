<!-- Main navigation bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-success-subtle">
    <div class="container">

        <!-- Brand / logo -->
        <a class="navbar-brand d-flex align-items-center" href="<?= APP_URL ?>">
            <img src="<?= APP_URL ?>/assets/images/logo.png"
                alt="Padel Verde"
                height="40"
                class="me-2">
            <span class="fw-bold">Club Padel Verde</span>
        </a>

        <!-- Mobile menu toggle -->
        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible navigation links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                <!-- Logout option for authenticated users -->
                <?php if (isset($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="<?= APP_URL ?>?controller=auth&action=logout">
                            Cerrar sesión
                        </a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>
