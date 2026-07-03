<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use Framework\Request;
use Framework\Response;
use Framework\ResponseFactory;

class AuthController
{
    public function __construct(
        private ResponseFactory $responseFactory,
        private UserRepository $userRepository,
        private AuthService $authService
    ) {
    }

    public function registerForm(Request $request): Response
    {
        return $this->responseFactory->view('auth/register.html.twig');
    }

    public function register(Request $request): Response
    {
        $firstName       = trim($request->get('first_name') ?? '');
        $lastName        = trim($request->get('last_name') ?? '');
        $email           = trim($request->get('email') ?? '');
        $password        = $request->get('password') ?? '';
        $confirmPassword = $request->get('confirm_password') ?? '';

        $errors = [];
        if ($firstName === '') {
            $errors['first_name'] = 'First name is required.';
        }
        if ($lastName === '') {
            $errors['last_name'] = 'Last name is required.';
        }
        if ($email === '') {
            $errors['email'] = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address.';
        } elseif ($this->userRepository->findByEmail($email) !== null) {
            $errors['email'] = 'An account with this email already exists.';
        }
        if ($password === '') {
            $errors['password'] = 'Password is required.';
        } elseif (strlen($password) < 8) {
            $errors['password'] = 'Password must be at least 8 characters.';
        } elseif ($password !== $confirmPassword) {
            $errors['confirm_password'] = 'Passwords do not match.';
        }

        if (!empty($errors)) {
            return $this->responseFactory->view('auth/register.html.twig', [
                'errors'     => $errors,
                'first_name' => $firstName,
                'last_name'  => $lastName,
                'email'      => $email,
            ]);
        }

        $user             = new User();
        $user->first_name = $firstName;
        $user->last_name  = $lastName;
        $user->email      = $email;

        $user = $this->authService->register($user, $password);
        $this->authService->forceLogin($user, $request->session);

        // New user goes to onboarding
        return $this->responseFactory->redirect('/onboarding');
    }

    public function loginForm(Request $request): Response
    {
        return $this->responseFactory->view('auth/login.html.twig');
    }

    public function login(Request $request): Response
    {
        $email    = trim($request->get('email') ?? '');
        $password = $request->get('password') ?? '';

        $errors = [];
        if ($email === '') {
            $errors['email'] = 'Email is required.';
        }
        if ($password === '') {
            $errors['password'] = 'Password is required.';
        }

        if (empty($errors)) {
            $user = $this->authService->loginWithCredentials($email, $password, $request->session);
            if ($user === false) {
                $errors['general'] = 'Invalid email or password.';
            } else {
                return $this->responseFactory->redirect('/checklist');
            }
        }

        return $this->responseFactory->view('auth/login.html.twig', [
            'errors' => $errors,
            'email'  => $email,
        ]);
    }

    public function logout(Request $request): Response
    {
        $this->authService->logout($request->session);
        return $this->responseFactory->redirect('/');
    }
}
