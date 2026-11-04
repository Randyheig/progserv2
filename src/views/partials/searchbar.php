<?php
/**
 * Barre de recherche + bouton Filtres (accueil et map).
 *
 * @var string $searchValue    texte déjà saisi
 * @var string|null $filtersHref  lien du bouton Filtres (accueil), sinon le bouton est dans la page map
 */
?>
<div class="search-field">
    <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10" cy="10" r="6.5"/><path d="M15 15l5.5 5.5"/></svg>
    <input type="search" name="q" value="<?= e($searchValue ?? '') ?>" aria-label="Rechercher un skatepark">
</div>
