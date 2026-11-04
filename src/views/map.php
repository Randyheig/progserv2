<?php
/**
 * @var \App\Entity\Skatepark[] $parks
 * @var array $markers
 * @var \App\Repository\SkateparkFilter $filter
 * @var \App\Entity\Module[] $allModules
 */
$filterActive = $filter->taille !== null || $filter->environnement !== null || $filter->moduleIds !== [];
?>
<section class="map-section">
    <h1 class="map-title">CARTE</h1>
    <div id="map" class="map" role="region" aria-label="Carte des skateparks"></div>
</section>

<section class="list-section list-section-map">
    <form class="searchbar searchbar-wrap" action="index.php" method="get" role="search">
        <input type="hidden" name="page" value="map">
        <?php $searchValue = $filter->q ?? ''; require APP_ROOT . '/views/partials/searchbar.php'; ?>

        <details class="filters" <?= $filterActive ? 'open' : '' ?>>
            <summary class="filters-btn">Filtres</summary>
            <div class="filters-panel">
                <label for="f-taille">Taille</label>
                <select id="f-taille" name="taille">
                    <option value="">Toutes</option>
                    <?php foreach (\App\Enum\Taille::cases() as $taille) { ?>
                        <option value="<?= e($taille->value) ?>" <?= $filter->taille === $taille ? 'selected' : '' ?>><?= e($taille->value) ?></option>
                    <?php } ?>
                </select>

                <label for="f-env">Indoor / Outdoor</label>
                <select id="f-env" name="env">
                    <option value="">Les deux</option>
                    <?php foreach (\App\Enum\Environnement::cases() as $env) { ?>
                        <option value="<?= e($env->value) ?>" <?= $filter->environnement === $env ? 'selected' : '' ?>><?= e($env->label()) ?></option>
                    <?php } ?>
                </select>

                <fieldset>
                    <legend>Modules</legend>
                    <?php foreach ($allModules as $module) { ?>
                        <label class="check">
                            <input type="checkbox" name="modules[]" value="<?= $module->id ?>" <?= in_array($module->id, $filter->moduleIds, true) ? 'checked' : '' ?>>
                            <?= e($module->libelle()) ?>
                        </label>
                    <?php } ?>
                </fieldset>

                <button type="submit" class="btn">Appliquer</button>
                <a class="btn btn-light" href="<?= e(url('map')) ?>">Réinitialiser</a>
            </div>
        </details>
    </form>

    <h2 class="sr-only"><?= count($parks) ?> skatepark<?= count($parks) > 1 ? 's' : '' ?></h2>

    <div class="cards">
        <?php foreach ($parks as $park) {
            require APP_ROOT . '/views/partials/skatepark_card.php';
        } ?>
    </div>

    <?php if ($parks === []) { ?>
        <p class="empty">Aucun skatepark ne correspond à cette recherche.</p>
    <?php } ?>
</section>

<script>
    var parks = <?= json_encode($markers, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE) ?>;
    var map = L.map('map').setView([46.6, 6.6], 9);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; contributeurs OpenStreetMap'
    }).addTo(map);

    var points = [];
    parks.forEach(function (park) {
        var link = document.createElement('a');
        link.href = park.url;
        link.textContent = park.nom;
        L.marker([park.lat, park.lng]).addTo(map).bindPopup(link);
        points.push([park.lat, park.lng]);
    });
    if (points.length > 1) {
        map.fitBounds(points, { padding: [30, 30] });
    } else if (points.length === 1) {
        map.setView(points[0], 14);
    }
</script>
