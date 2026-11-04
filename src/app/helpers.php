<?php

declare(strict_types=1);

/** Échappe une valeur pour l'afficher dans du HTML (protection XSS). */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Construit l'URL relative d'une page de l'application. */
function url(string $page, array $params = []): string
{
    return 'index.php?' . http_build_query(['page' => $page] + $params);
}

/** URL relative d'une image de src/public/img si le fichier existe, sinon null (le visuel de secours prend le relais). */
function image_url(string $name): ?string
{
    return is_file(APP_ROOT . '/public/img/' . $name) ? 'img/' . $name : null;
}
