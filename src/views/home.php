<?php
/**
 * @var \App\Entity\Skatepark[] $parks
 * @var bool $nearby
 */
$heroImage = image_url('accueil.jpg');
?>
<section class="home-hero" <?= $heroImage !== null ? 'style="background-image: url(\'' . e($heroImage) . '\')"' : '' ?>>
    <h1 class="sr-only">Skatearth, les skateparks vaudois</h1>
</section>

<section class="list-section">
    <form class="searchbar" action="index.php" method="get" role="search">
        <input type="hidden" name="page" value="map">
        <?php $searchValue = ''; require APP_ROOT . '/views/partials/searchbar.php'; ?>
        <a class="filters-btn" href="<?= e(url('map')) ?>">Filtres</a>
    </form>

    <h2 class="sr-only"><?= $nearby ? 'Les skateparks les plus proches de toi' : 'Derniers skateparks ajoutés' ?></h2>

    <div class="cards">
        <?php foreach ($parks as $park) {
            require APP_ROOT . '/views/partials/skatepark_card.php';
        } ?>
    </div>

    <?php if ($parks === []) { ?>
        <p class="empty">Aucun skatepark pour le moment.</p>
    <?php } ?>
</section>

<?php if (!$nearby) { ?>
    <script>
        // Position du navigateur : l'accueil se recharge une fois avec les 5 skateparks les plus proches.
        if ('geolocation' in navigator && !sessionStorage.getItem('geoTried')) {
            sessionStorage.setItem('geoTried', '1');
            navigator.geolocation.getCurrentPosition(function (position) {
                location.replace('index.php?page=home&lat=' + position.coords.latitude.toFixed(5)
                    + '&lng=' + position.coords.longitude.toFixed(5));
            });
        }
    </script>
<?php } ?>
