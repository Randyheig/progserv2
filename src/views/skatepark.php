<?php
/**
 * @var \App\Entity\Skatepark $park
 */
$photos = $park->getPhotos();
$siteWeb = $park->siteWebUrl();
$instagram = $park->instagram();
?>
<?php if ($photos !== []) { ?>
    <img class="park-hero" src="<?= e($photos[0]->getChemin()) ?>" alt="Photo principale de <?= e($park->getNom()) ?>">
<?php } else { ?>
    <div class="park-hero park-hero-empty"></div>
<?php } ?>

<section class="park">
    <h1 class="park-title"><?= e($park->getNom()) ?></h1>

    <?php if ($siteWeb !== null) { ?>
        <p class="park-link"><a href="<?= e($siteWeb) ?>" target="_blank" rel="noopener noreferrer"><?= e(str_replace(['https://', 'http://'], '', $siteWeb)) ?></a></p>
    <?php } ?>
    <?php if ($instagram !== null) { ?>
        <p class="park-link">
            <svg class="icon-insta" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r="0.6"/></svg>
            <a href="https://www.instagram.com/<?= e(rawurlencode($instagram)) ?>" target="_blank" rel="noopener noreferrer"><?= e($instagram) ?></a>
        </p>
    <?php } ?>

    <div class="park-info">
        <div>
            <h2>Details:</h2>
            <ul>
                <li><?= e(ucfirst($park->getEnvironnement())) ?></li>
                <li><?= e($park->getTaille()) ?></li>
                <?php if ($park->getInformationsSupplementaires() !== null) { ?>
                    <li><?= nl2br(e($park->getInformationsSupplementaires())) ?></li>
                <?php } ?>
            </ul>
        </div>
        <div>
            <h2>Modules :</h2>
            <ul>
                <?php foreach ($park->getModules() as $module) { ?>
                    <li><?= e($module->libelle()) ?></li>
                <?php } ?>
                <?php if ($park->getModules() === []) { ?>
                    <li>Non renseignés</li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <?php if (count($photos) > 1) { ?>
        <div class="gallery">
            <?php foreach (array_slice($photos, 1) as $photo) { ?>
                <img src="<?= e($photo->getChemin()) ?>" alt="Photo de <?= e($park->getNom()) ?>" loading="lazy">
            <?php } ?>
        </div>
    <?php } ?>

    <div class="park-address">
        <h2>Adresse :</h2>
        <p><?= nl2br(e($park->getAdresse())) ?></p>
    </div>

    <?php if ($park->hasCoordinates()) { ?>
        <div id="park-map" class="map park-map" role="region" aria-label="Carte du skatepark"></div>
        <script>
            var position = <?= json_encode([$park->getCoordonnees()->getLatitude(), $park->getCoordonnees()->getLongitude()]) ?>;
            var parkMap = L.map('park-map').setView(position, 15);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; contributeurs OpenStreetMap'
            }).addTo(parkMap);
            L.marker(position).addTo(parkMap);
        </script>
    <?php } ?>
</section>
