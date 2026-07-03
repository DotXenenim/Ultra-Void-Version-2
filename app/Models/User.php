<?php

declare(strict_types=1);

namespace App\Models;

class User
{
    public int $id;
    public string $first_name;
    public string $last_name;
    public string $email;
    public string $password;
    public ?string $date_of_birth = null;
    public ?bool $is_eu           = null;
    public ?bool $is_working      = null;
    public ?string $housing_type  = null;
    public ?string $program_type  = null;
    public ?bool $has_admission   = null;
    public string $created_at;
    public string $updated_at;
}
