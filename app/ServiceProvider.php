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
//
//        $userRepository = new AdminRepository($database);
//        $authService = new AuthService($userRepository);
//
//        $adminRepository = new AdminRepository($database);
//        $container->set(AdminRepository::class, $adminRepository);
//
//        $projectRepository = new ProjectRepository($database);
//        $container->set(ProjectRepositoryInterface::class, $projectRepository);
//
//        $reportRepository = new ReportRepository($database);
//        $container->set(ReportRepositoryInterface::class, $reportRepository);
//
//        $componentRepository = new ComponentRepository($database);
//        $container->set(ComponentRepositoryInterface::class, $componentRepository);
//
//        $quarterlyReportRepository = new QuarterlyReportRepository($database);
//        $container->set(QuarterlyReportRepositoryInterface::class, $quarterlyReportRepository);
//
      $homeController = new HomeController($responseFactory);
$container->set(HomeController::class, $homeController);
//
//        $adminController = new AdminController($responseFactory, $adminRepository, $authService);
//        $container->set(AdminController::class, $adminController);
//
//        $authMiddleware = new AuthMiddleware($responseFactory, $authService);
//        $container->set(AuthMiddleware::class, $authMiddleware);
//
//        $quarterlyService = new QuarterlyService($quarterlyReportRepository);
//        $userController = new UserController(
//            $responseFactory,
//            $projectRepository,
//            $reportRepository,
//            $componentRepository,
//            $quarterlyService,
//            $userRepository,
//        );
//        $container->set(UserController::class, $userController);
//
//        $projectService = new ProjectService($adminRepository, $projectRepository);
//        $projectController = new ProjectController($responseFactory, $projectRepository, $adminRepository, $projectService, $componentRepository);
//        $container->set(ProjectController::class, $projectController);
//
//        $sectionRepository = new SectionRepository($database);
//        $container->set(SectionRepositoryInterface::class, $sectionRepository);
//
//        $subjectRepository = new SubjectRepository($database);
//        $container->set(SubjectRepositoryInterface::class, $subjectRepository);
//
//        $descriptionRepository = new DescriptionRepository($database);
//        $container->set(DescriptionRepositoryInterface::class, $descriptionRepository);
//
//        $tableService = new TableService(
//            $sectionRepository,
//            $subjectRepository,
//            $componentRepository,
//            $descriptionRepository
//        );
//
//        $tableController = new TableController(
//            $responseFactory,
//            $projectRepository,
//            $reportRepository,
//            $sectionRepository,
//            $subjectRepository,
//            $componentRepository,
//            $descriptionRepository,
//            $adminRepository,
//            $tableService
//        );
//        $container->set(TableController::class, $tableController);
//
//        $reportController = new ReportController(
//            $responseFactory,
//            $reportRepository,
//            $projectRepository,
//            $tableService
//        );
//        $container->set(ReportController::class, $reportController);
//
//        $quarterlyReportController = new QuarterlyReportController(
//            $responseFactory,
//            $tableService,
//            $quarterlyService,
//            $projectRepository,
//            $adminRepository
//        );
//        $container->set(QuarterlyReportController::class, $quarterlyReportController);
//
//        $apiController = new ApiController(
//            $responseFactory,
//            $sectionRepository,
//            $subjectRepository,
//            $componentRepository,
//            $descriptionRepository,
//        );
//        $container->set(ApiController::class, $apiController);
   }
}

