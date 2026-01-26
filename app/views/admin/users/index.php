<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<?php
// Generates sortable table header links
function sortLink($label, $field)
{
    $currentSort = $_GET['sort'] ?? 'name';
    $currentDir  = $_GET['dir'] ?? 'asc';
    $dir = ($currentSort === $field && $currentDir === 'asc') ? 'desc' : 'asc';

    // Build query string preserving filters
    $query = array_merge($_GET, [
        'controller' => 'adminUser',
        'action' => 'index',
        'sort' => $field,
        'dir' => $dir
    ]);

    $url = APP_URL . '?' . http_build_query($query);

    // Display sort direction arrow
    $arrow = '';
    if ($currentSort === $field) {
        $arrow = $currentDir === 'asc' ? ' ▲' : ' ▼';
    }

    return "<a href=\"$url\">$label$arrow</a>";
}
?>

<!-- Admin view: user management -->
<h2 class="mb-3">Gestión de usuarios</h2>

<!-- Flash message feedback -->
<?php if ($flash = getFlash()): ?>
    <div class="alert alert-<?= $flash['type'] ?>">
        <?= htmlspecialchars($flash['message']) ?>
    </div>
<?php endif; ?>

<!-- Breadcrumb navigation -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= APP_URL ?>">Inicio</a>
        </li>
        <li class="breadcrumb-item">
            <a href="<?= APP_URL ?>?controller=admin&action=dashboard">
                Administración
            </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            Usuarios
        </li>
    </ol>
</nav>

<div class="card shadow-sm">
    <div class="card-body table-responsive">

        <!-- Filter and search form -->
        <form method="get" class="row g-2 mb-3">

            <input type="hidden" name="controller" value="adminUser">
            <input type="hidden" name="action" value="index">

            <!-- Search input -->
            <div class="col-md-4">
                <input type="text"
                    name="search"
                    class="form-control"
                    placeholder="Buscar por nombre o email"
                    value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            </div>

            <!-- Role filter -->
            <div class="col-md-2">
                <select name="role" class="form-select">
                    <option value="">Todos los roles</option>
                    <option value="admin" <?= ($_GET['role'] ?? '') === 'admin' ? 'selected' : '' ?>>
                        Admin
                    </option>
                    <option value="user" <?= ($_GET['role'] ?? '') === 'user' ? 'selected' : '' ?>>
                        Usuario
                    </option>
                </select>
            </div>

            <!-- Active status filter -->
            <div class="col-md-2">
                <select name="active" class="form-select">
                    <option value="">Todos</option>
                    <option value="1" <?= ($_GET['active'] ?? '') === '1' ? 'selected' : '' ?>>
                        Activos
                    </option>
                    <option value="0" <?= ($_GET['active'] ?? '') === '0' ? 'selected' : '' ?>>
                        Inactivos
                    </option>
                </select>
            </div>

            <!-- Submit filters -->
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-primary mb-3">
                    Filtrar
                </button>
            </div>

            <!-- Create new user -->
            <div class="col-md-2 d-grid">
                <a href="<?= APP_URL ?>?controller=adminUser&action=create"
                    class="btn btn-success mb-3">
                    Nuevo usuario
                </a>
            </div>
        </form>

        <!-- User table -->
        <table class="table align-middle">
            <thead class="table-light">
                <tr>
                    <th><?= sortLink('Nombre', 'name') ?></th>
                    <th><?= sortLink('Email', 'email') ?></th>
                    <th><?= sortLink('Nivel', 'level') ?></th>
                    <th><?= sortLink('Rol', 'role') ?></th>
                    <th><?= sortLink('Estado', 'active') ?></th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <!-- User name -->
                        <td><?= htmlspecialchars($user['full_name']) ?></td>

                        <!-- User email -->
                        <td><?= htmlspecialchars($user['email']) ?></td>

                        <!-- User level -->
                        <td>
                            <span class="badge bg-info text-dark">
                                <?= (int)$user['level'] ?>
                            </span>
                        </td>

                        <!-- User role -->
                        <td>
                            <span class="badge bg-info text-dark">
                                <?= ucfirst($user['role']) ?>
                            </span>
                        </td>

                        <!-- User status -->
                        <td>
                            <?php if ($user['active']): ?>
                                <span class="badge bg-success">Activo</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Inactivo</span>
                            <?php endif; ?>
                        </td>

                        <!-- Action buttons -->
                        <td class="text-end">
                            <a href="<?= APP_URL ?>?controller=adminUser&action=edit&id=<?= $user['id'] ?>"
                                class="btn btn-sm btn-outline-primary">
                                Editar
                            </a>

                            <?php if ($user['active']): ?>
                                <a href="<?= APP_URL ?>?controller=adminUser&action=toggle&id=<?= $user['id'] ?>&action_type=deactivate"
                                    class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('¿Desactivar este usuario?');">
                                    Desactivar
                                </a>
                            <?php else: ?>
                                <a href="<?= APP_URL ?>?controller=adminUser&action=toggle&id=<?= $user['id'] ?>&action_type=activate"
                                    class="btn btn-sm btn-outline-success">
                                    Activar
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <nav class="mt-3">
                <ul class="pagination justify-content-center">

                    <?php
                    // Base query for pagination links
                    $queryBase = $_GET;
                    ?>

                    <!-- Previous page -->
                    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                        <?php $queryBase['page'] = $page - 1; ?>
                        <a class="page-link" href="<?= APP_URL . '?' . http_build_query($queryBase) ?>">
                            Anterior
                        </a>
                    </li>

                    <!-- Page numbers -->
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <?php $queryBase['page'] = $i; ?>
                        <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                            <a class="page-link"
                                href="<?= APP_URL . '?' . http_build_query($queryBase) ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <!-- Next page -->
                    <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                        <?php $queryBase['page'] = $page + 1; ?>
                        <a class="page-link" href="<?= APP_URL . '?' . http_build_query($queryBase) ?>">
                            Siguiente
                        </a>
                    </li>

                </ul>
            </nav>
        <?php endif; ?>

    </div>
</div>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>
