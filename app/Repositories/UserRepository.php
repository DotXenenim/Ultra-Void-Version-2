<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use Framework\Database;

class UserRepository implements UserRepositoryInterface
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function findById(int $id): ?User
    {
        $row = $this->db->run(
            'SELECT * FROM users WHERE id = :id',
            ['id' => $id]
        )->fetch();
        return $row ? $this->fromRow($row) : null;
    }

    public function findByEmail(string $email): ?User
    {
        $row = $this->db->run(
            'SELECT * FROM users WHERE email = :email',
            ['email' => $email]
        )->fetch();
        return $row ? $this->fromRow($row) : null;
    }

    public function insert(User $user): User
    {
        $this->db->run(
            'INSERT INTO users (first_name, last_name, email, password)
             VALUES (:first_name, :last_name, :email, :password)',
            [
                'first_name' => $user->first_name,
                'last_name'  => $user->last_name,
                'email'      => $user->email,
                'password'   => $user->password,
            ]
        );
        $user->id = $this->db->getLastID();
        return $user;
    }

    public function update(User $user): User
    {
        $this->db->run(
            'UPDATE users SET
                date_of_birth = :dob,
                is_eu         = :is_eu,
                is_working    = :is_working,
                housing_type  = :housing_type,
                program_type  = :program_type,
                has_admission = :has_admission
             WHERE id = :id',
            [
                'dob'          => $user->date_of_birth,
                'is_eu'        => $user->is_eu === null ? null : (int)$user->is_eu,
                'is_working'   => $user->is_working === null ? null : (int)$user->is_working,
                'housing_type' => $user->housing_type,
                'program_type' => $user->program_type,
                'has_admission'=> $user->has_admission === null ? null : (int)$user->has_admission,
                'id'           => $user->id,
            ]
        );
        return $user;
    }

    private function fromRow(mixed $row): User
    {
        $user                = new User();
        $user->id            = (int)$row->id;
        $user->first_name    = $row->first_name;
        $user->last_name     = $row->last_name;
        $user->email         = $row->email;
        $user->password      = $row->password;
        $user->date_of_birth = $row->date_of_birth;
        $user->is_eu         = $row->is_eu === null ? null : (bool)$row->is_eu;
        $user->is_working    = $row->is_working === null ? null : (bool)$row->is_working;
        $user->housing_type  = $row->housing_type;
        $user->program_type  = $row->program_type;
        $user->has_admission = $row->has_admission === null ? null : (bool)$row->has_admission;
        $user->created_at    = $row->created_at ?? '';
        $user->updated_at    = $row->updated_at ?? '';
        return $user;
    }
}
