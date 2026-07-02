<?php

namespace App\Controllers;

use App\Models\User;
use App\Services\AuthService;
use Framework\Request;
use Framework\Response;
use Framework\ResponseFactory;

class HomeController
{
    private ResponseFactory $responseFactory;
    public function __construct(
        ResponseFactory $responseFactory,
        ) {
        $this->responseFactory = $responseFactory;
    }

    public function index(): Response
    {
        return $this->responseFactory->view('index.html.twig');
    }

    // public function login(Request $request): Response
    // {
    //     $username = $request->get("username") ?? '';
    //     $password = $request->get("password") ?? '';
    //     if ($username == '' || $password == '') {
    //         $error = "Fill in all your credentials please.";
    //         return $this->getView($error, $username, $password);
    //     }
    //     if (!$this->authService->checkUsername($username)) {
    //         $error = "Wrong username.";
    //         return $this->getView($error, $username, $password);
    //     }
    //     $user = $this->authService->login($username, $password);

    //     if ($user === null) {
    //         $error = "Wrong password.";
    //         return $this->getView($error, $username, $password);
    //     }
    //     $request->session->setAttribute(User::class, $user);
    //     return match ($user->role) {
    //         "Admin" => $this->responseFactory->redirect(strtolower($user->role) . "/users"),

    //         "Project Lead",
    //         "Project Manager",
    //         "Superuser" => $this->responseFactory->redirect("/projects"),

    //         default => $this->responseFactory->notFound(),
    //     };
    // }
    
    public function logout(Request $request): Response
    {
        $session = $request->session;
        $session->destroy();
        return $this->responseFactory->redirect("/");
    }

    /**
     * @param string $error
     * @param string $username
     * @param string $password
     * @return mixed
     */
    private function getView(string $error, string $username, string $password)
    {
        return $this->responseFactory->view(
            "index.html.twig",
            [
                "error" => $error,
                "username" => $username,
                "password" => $password
            ]
        );
    }
}
