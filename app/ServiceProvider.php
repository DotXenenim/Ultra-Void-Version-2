<?php

namespace App;

use App\Controllers\AdminController;
use App\Controllers\ApiController;
use App\Controllers\HomeController;
use App\Controllers\ProjectController;
use App\Controllers\QuarterlyReportController;
use App\Controllers\ReportController;
use App\Controllers\UserController;
use App\Controllers\TableController;
use App\Middlewares\AuthMiddleware;
use App\Repositories\AdminRepository;
use App\Repositories\ComponentRepository;
use App\Repositories\ComponentRepositoryInterface;
use App\Repositories\DescriptionRepository;
use App\Repositories\DescriptionRepositoryInterface;
use App\Repositories\ProjectRepository;
use App\Repositories\ProjectRepositoryInterface;
use App\Repositories\QuarterlyReportRepository;
use App\Repositories\QuarterlyReportRepositoryInterface;
use App\Repositories\ReportRepository;
use App\Repositories\ReportRepositoryInterface;
use App\Repositories\SectionRepository;
use App\Repositories\SectionRepositoryInterface;
use App\Repositories\SubjectRepository;
use App\Repositories\SubjectRepositoryInterface;
use App\Services\AuthService;
use App\Services\ProjectService;
use App\Services\QuarterlyService;
use App\Services\TableService;
use Exception;
use Framework\Database;
use Framework\ResponseFactory;
use Framework\ServiceContainer;
use Framework\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * @throws Exception
     */
    public function register(ServiceContainer $container): void
    {
        $responseFactory = $container->get(ResponseFactory::class);
        $database = $container->get(Database::class);

        //$authService = new AuthService($userRepository);

        $homeController = new HomeController($responseFactory);
        $container->set(HomeController::class, $homeController);

        $authMiddleware = new AuthMiddleware($responseFactory);
        $container->set(AuthMiddleware::class, $authMiddleware);
    }
}
