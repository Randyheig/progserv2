<?php
/**
 * Carte d'un skatepark (accueil, map).
 *
 * @var \App\Entity\Skatepark $park
 */
$fiche = url('skatepark', ['id' => $park->getId()]);
?>
<a class="card" href="<?= e($fiche) ?>">
    <span class="card-photo">
        <?php if ($park->getPhotoPrincipale() !== null) { ?>
            <img src="<?= e($park->getPhotoPrincipale()) ?>" alt="Photo de <?= e($park->getNom()) ?>" loading="lazy">
        <?php } else { ?>
            <span class="no-photo">Pas de photo</span>
        <?php } ?>
    </span>
    <span class="card-body">
        <span class="card-title"><?= e($park->getNom()) ?></span>
        <span class="card-meta">
            <span class="badge"><?= e($park->getTaille()) ?></span>
            <span class="card-address"><?= e($park->getAdresse()) ?></span>
        </span>
        <?php if ($park->getDistanceKm() !== null) { ?>
            <span class="card-distance">À <?= e(number_format($park->getDistanceKm(), 1, '.', '')) ?> km</span>
        <?php } ?>
    </span>
</a>
