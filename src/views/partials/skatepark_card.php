<?php
/**
 * Carte d'un skatepark (accueil, map).
 *
 * @var \App\Entity\Skatepark $park
 */
$fiche = url('skatepark', ['id' => $park->id]);
?>
<a class="card" href="<?= e($fiche) ?>">
    <span class="card-photo">
        <?php if ($park->photoPrincipale !== null) { ?>
            <img src="<?= e($park->photoPrincipale) ?>" alt="Photo de <?= e($park->nom) ?>" loading="lazy">
        <?php } else { ?>
            <span class="no-photo">Pas de photo</span>
        <?php } ?>
    </span>
    <span class="card-body">
        <span class="card-title"><?= e($park->nom) ?></span>
        <span class="card-meta">
            <span class="badge"><?= e($park->taille->value) ?></span>
            <span class="card-address"><?= e($park->adresse) ?></span>
        </span>
        <?php if ($park->distanceKm !== null) { ?>
            <span class="card-distance">À <?= e(number_format($park->distanceKm, 1, '.', '')) ?> km</span>
        <?php } ?>
    </span>
</a>
