<?php

function getValidGetRoutes(): array
{
    $routes = Illuminate\Support\Facades\Route::getRoutes();
    $getRoutes = [];


    foreach ($routes as $route) {
        if (in_array('GET', $route->methods())) {
            $uri = $route->uri();

            // Exclude routes starting with 'api'
            if (str_starts_with($uri, 'api')) {
                continue;
            }

            $action = $route->getAction();

            // Only consider routes that have a controller action defined
            if (isset($action['controller'])) {
                [$controller, $method] = explode('@', $action['controller']);

                // Check if the method exists within the controller
                if (method_exists(app($controller), $method)) {
                    $getRoutes[] = $uri;
                }
            }
        }
    }

    return $getRoutes;
}
