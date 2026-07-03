<?php

declare(strict_types=1);

namespace App;

use App\Controllers\AuthController;
use App\Controllers\ChecklistController;
use App\Controllers\HomeController;
use App\Controllers\OnboardingController;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;
use App\Repositories\FormRepository;
use App\Repositories\FormRepositoryInterface;
use App\Repositories\FormStepRepository;
use App\Repositories\FormStepRepositoryInterface;
use App\Repositories\StepRepository;
use App\Repositories\StepRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Services\AuthService;
use App\Services\CsrfService;
use Framework\Database;
use Framework\ResponseFactory;
use Framework\ServiceContainer;
use Framework\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(ServiceContainer $container): void
    {
        $responseFactory = $container->get(ResponseFactory::class);
        $database        = $container->get(Database::class);

        // Repositories
        $userRepository     = new UserRepository($database);
        $container->set(UserRepositoryInterface::class, $userRepository);

        $stepRepository     = new StepRepository($database);
        $container->set(StepRepositoryInterface::class, $stepRepository);

        $formRepository     = new FormRepository($database);
        $container->set(FormRepositoryInterface::class, $formRepository);

        $formStepRepository = new FormStepRepository($database);
        $container->set(FormStepRepositoryInterface::class, $formStepRepository);

        // Auth & CSRF
        $authService    = new AuthService($userRepository);
        $authMiddleware = new AuthMiddleware($authService, $responseFactory);
        $container->set(AuthMiddleware::class, $authMiddleware);

        $csrfService    = new CsrfService($responseFactory);
        $csrfMiddleware = new CsrfMiddleware($csrfService);
        $container->set(CsrfMiddleware::class, $csrfMiddleware);

        // Controllers
        $homeController = new HomeController($responseFactory);
        $container->set(HomeController::class, $homeController);

        $authController = new AuthController($responseFactory, $userRepository, $authService);
        $container->set(AuthController::class, $authController);

        $onboardingController = new OnboardingController(
            $responseFactory,
            $userRepository,
            $stepRepository,
            $formRepository,
            $formStepRepository
        );
        $container->set(OnboardingController::class, $onboardingController);

        $checklistController = new ChecklistController(
            $responseFactory,
            $formRepository,
            $formStepRepository
        );
        $container->set(ChecklistController::class, $checklistController);
    }
}
