<?php

declare(strict_types=1);

/**
 * Point d'entrée unique : chaque page s'appelle avec index.php?page=...
 * Le code de l'application vit dans src/app, hors du dossier public.
 */

const APP_ROOT = __DIR__ . '/..';

require APP_ROOT . '/app/helpers.php';

// Chargement automatique : App\Core\Router => src/app/Core/Router.php
spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    if (!str_starts_with($class, $prefix)) {
        return;
    }
    $file = APP_ROOT . '/app/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
    if (is_file($file)) {
        require $file;
    }
});

use App\Controller\HomeController;
use App\Controller\MapController;
use App\Controller\SkateparkController;
use App\Core\Database;
use App\Core\Router;

Database::configure((require APP_ROOT . '/config/config.php')['db']);

$router = new Router();
$router->get('home', [HomeController::class, 'index']);
$router->get('map', [MapController::class, 'index']);
$router->get('skatepark', [SkateparkController::class, 'show']);

$page = is_string($_GET['page'] ?? null) ? $_GET['page'] : 'home';
$router->dispatch($page, $_SERVER['REQUEST_METHOD']);
