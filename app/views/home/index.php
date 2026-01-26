<?php require_once __DIR__ . '/../partials/header.php'; ?>

<!-- Public home page / hero section -->
<section class="mb-5">
    <div class="row align-items-center">
        <div class="col-lg-6">
            <!-- Main title -->
            <h1 class="mb-3">Club Pádel Verde</h1>

            <!-- Introductory text -->
            <p class="lead">
                Bienvenido al Club Pádel Verde, un espacio dedicado al deporte,
                la competición y el disfrute del pádel en un entorno moderno y accesible.
            </p>

            <!-- Platform description -->
            <p>
                Desde esta plataforma podrás consultar la disponibilidad de pistas,
                gestionar tus reservas y acceder a tu panel personal como jugador o administrador.
            </p>

            <!-- Call to action depending on user session -->
            <?php if (!isset($_SESSION['user'])): ?>
                <!-- Login button for guests -->
                <a href="<?= APP_URL ?>?controller=auth&action=login"
                   class="btn btn-success me-2">
                    Iniciar sesión
                </a>
            <?php else: ?>
                <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                    <!-- Admin dashboard access -->
                    <a href="<?= APP_URL ?>?controller=admin&action=dashboard"
                       class="btn btn-success">
                        Ir al panel de administración
                    </a>
                <?php else: ?>
                    <!-- User dashboard access -->
                    <a href="<?= APP_URL ?>?controller=user&action=dashboard"
                       class="btn btn-success">
                        Ir a mi panel
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- Corporate image -->
        <div class="col-lg-6 text-center">
            <img src="<?= APP_URL ?>/assets/images/courts/image_corp.png"
                 alt="Imagen corporativa del Club Pádel Verde"
                 class="img-fluid rounded shadow-sm">
        </div>
    </div>
</section>

<!-- Informational section -->
<section class="mb-5">
    <div class="row g-4">

        <!-- Facilities card -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Instalaciones</h5>
                    <p class="card-text">
                        El club dispone de pistas modernas, cuidadas y adaptadas
                        tanto a jugadores amateur como a nivel competitivo.
                    </p>
                </div>
            </div>
        </div>

        <!-- Online booking card -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Reservas online</h5>
                    <p class="card-text">
                        Consulta disponibilidad y reserva tu pista cómodamente
                        desde cualquier dispositivo.
                    </p>
                </div>
            </div>
        </div>

        <!-- Management system card -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Gestión eficiente</h5>
                    <p class="card-text">
                        Sistema de gestión para usuarios y administradores,
                        pensado para facilitar la organización del club.
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>

