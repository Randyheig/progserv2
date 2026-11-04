<header class="site-header">
    <details class="menu">
        <summary aria-label="Menu"><span></span><span></span><span></span></summary>
        <nav>
            <a href="<?= e(url('home')) ?>">Accueil</a>
            <a href="<?= e(url('map')) ?>">Map</a>
        </nav>
    </details>

    <a class="logo" href="<?= e(url('home')) ?>" aria-label="Skatearth, accueil">
        <?php require APP_ROOT . '/views/partials/logo.php'; ?>
    </a>

    <!-- Emplacement du bouton de connexion (comptes pas encore actifs) -->
    <span class="login-circle" aria-hidden="true"></span>
</header>
