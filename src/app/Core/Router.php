<?php

declare(strict_types=1);

namespace App\Core;

/** Associe le paramètre ?page= et la méthode HTTP à une action de contrôleur. */
<<<<<<< HEAD
class Router
=======
final class Router
>>>>>>> origin/main
{
    /** @var array<string, array<string, array{0: class-string, 1: string}>> */
    private array $routes = [];

    /** @param array{0: class-string, 1: string} $handler */
    public function get(string $page, array $handler): void
    {
        $this->routes['GET'][$page] = $handler;
    }

    /** @param array{0: class-string, 1: string} $handler */
    public function post(string $page, array $handler): void
    {
        $this->routes['POST'][$page] = $handler;
    }

    public function dispatch(string $page, string $method): void
    {
        $method = $method === 'HEAD' ? 'GET' : $method;
        $handler = $this->routes[$method][$page] ?? null;

        if ($handler === null) {
            http_response_code(404);
            View::render('404', ['title' => 'Page introuvable']);
            return;
        }

        [$class, $action] = $handler;
        (new $class())->$action();
    }
}
