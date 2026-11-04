<?php

declare(strict_types=1);

namespace App\Core;

/** Affiche un template de src/views à l'intérieur du layout commun. */
<<<<<<< HEAD
class View
=======
final class View
>>>>>>> origin/main
{
    public static function render(string $template, array $data = []): void
    {
        extract($data, EXTR_SKIP);

        ob_start();
        require APP_ROOT . '/views/' . $template . '.php';
        $content = ob_get_clean();

        require APP_ROOT . '/views/layout.php';
    }
}
