<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\AdminRepository;
use Framework\Request;
use Framework\Session;

class AuthService
{
    private AdminRepository $adminRepository;

    public function __construct(AdminRepository $userRepository)
    {
        $this->adminRepository = $userRepository;
    }

    public function register(User $user, ?string $password): User
    {
        if ($password == null) {
            $user->password = null;
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $user->password = $passwordHash;
        }
        $this->adminRepository->insertUser($user);
        return $user;
    }

    public function login(string $username, string $password): ?User
    {
        $userRepo = $this->adminRepository->getUserByUsername($username);
        if ($userRepo === null) {
            return null;
        }
        $password_hash = $userRepo->password;
        return password_verify($password, $password_hash) ? $userRepo : null;
    }
    public function validateUser(?object $user, string $requiredRole): bool
    {
        $role = $user->role ?? '';
        if ($requiredRole == 'User' && $role !== 'Admin') {
            return true;
        }
        return $role === $requiredRole;
    }
    public function checkCredentials(?object $user): bool
    {
        return $user !== null;
    }
    public function checkUsername($username): bool
    {
        return $this->adminRepository->getUserByUsername($username) !== null;
    }

    public function isLeadAssignedToProject(User $user, int $projectId): bool{
        $assignedUser = $this->adminRepository->getUserByAssignedProject($projectId);
        return $assignedUser == $user;
    }
}
