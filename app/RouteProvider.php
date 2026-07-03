<?php

declare(strict_types=1);

namespace App;

use App\Controllers\AuthController;
use App\Controllers\ChecklistController;
use App\Controllers\HomeController;
use App\Controllers\OnboardingController;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;
use Framework\RouteProviderInterface;
use Framework\Router;
use Framework\ServiceContainer;

class RouteProvider implements RouteProviderInterface
{
    public function register(Router $router, ServiceContainer $container): void
    {
        $authMiddleware = $container->get(AuthMiddleware::class);
        $csrfMiddleware = $container->get(CsrfMiddleware::class);

        // Public
        $homeController = $container->get(HomeController::class);
        $router->addRoute('GET', '/', [$homeController, 'index']);

        // Auth
        $authController = $container->get(AuthController::class);
        $router->addRoute('GET',  '/register', [$authController, 'registerForm']);
        $router->addRoute('POST', '/register', [$authController, 'register']);
        $router->addRoute('GET',  '/login',    [$authController, 'loginForm']);
        $router->addRoute('POST', '/login',    [$authController, 'login']);
        $router->addRoute('GET',  '/logout',   [$authController, 'logout']);

        // Onboarding (requires auth)
        $onboardingController = $container->get(OnboardingController::class);
        $r = $router->addRoute('GET',  '/onboarding', [$onboardingController, 'show']);
        $r->addMiddleware([$authMiddleware, 'requireAuth']);
        $r2 = $router->addRoute('POST', '/onboarding', [$onboardingController, 'save']);
        $r2->addMiddleware([$authMiddleware, 'requireAuth']);

        // Checklist (requires auth)
        $checklistController = $container->get(ChecklistController::class);
        $r3 = $router->addRoute('GET',  '/checklist',        [$checklistController, 'index']);
        $r3->addMiddleware([$authMiddleware, 'requireAuth']);
        $r4 = $router->addRoute('POST', '/checklist/toggle', [$checklistController, 'toggle']);
        $r4->addMiddleware([$authMiddleware, 'requireAuth']);

        // Global middleware
        $router->addMiddleware([$authMiddleware, 'handle']);
        $router->addMiddleware([$csrfMiddleware, 'handle']);
    }
}
