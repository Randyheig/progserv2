<?php

declare(strict_types=1);

namespace App\Core;

/** Classe de base des contrôleurs : rendu d'une vue et lecture des paramètres de l'URL. */
abstract class Controller
{
    protected function render(string $template, array $data = [], int $status = 200): void
    {
        http_response_code($status);
        View::render($template, $data);
    }

    /** Valeur texte d'un paramètre GET, ou null. */
    protected function query(string $key): ?string
    {
        $value = $_GET[$key] ?? null;
        return is_string($value) ? $value : null;
    }
}
