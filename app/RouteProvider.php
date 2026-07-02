<?php

namespace App;

use App\Middlewares\AuthMiddleware;
use Framework\Router;
use Framework\RouteProviderInterface;
use Framework\ServiceContainer;

class RouteProvider implements RouteProviderInterface
{
    /**
     * @throws \Exception
     */
    public function register(Router $router, ServiceContainer $container): void
    {
        $authMiddleware = $container->get(AuthMiddleware::class);

        $homeController = $container->get(HomeController::class);
        $router->addRoute('GET', '/', [$homeController, 'index']);
    }
}
