<?php

namespace App\Middlewares;

use App\Models\User;
use App\Repositories\ProjectRepository;
use App\Services\AuthService;
use Framework\Request;
use Framework\Response;
use Framework\ResponseFactory;

class AuthMiddleware
{
    private ResponseFactory $responseFactory;
    //private AuthService $authService;

    public function __construct(
        ResponseFactory $responseFactory,
        //AuthService $authService,
    ) {
        $this->responseFactory = $responseFactory;
        //$this->authService = $authService;
    }

    public function requireAdmin(Request $request, callable $next): Response
    {
        return $this->requireRole($request, $next, 'Admin');
    }

    public function requireUser(Request $request, callable $next): Response
    {
        return $this->requireRole($request, $next, 'User');
    }
    private function requireRole(
        Request $request,
        callable $next,
        string $requiredRole
    ): Response {
        $session = $request->session;
        $user = $session->getAttribute(User::class);
        if (!$this->authService->checkCredentials($user)) {
            return $this->responseFactory->unAuthorized();
        }
        if ($this->authService->validateUser($user, $requiredRole)) {
            return $next($request);
        } else {
            return $this->responseFactory->forbidden();
        }
    }
}
