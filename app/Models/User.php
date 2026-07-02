<?php

namespace App\Models;

class User
{
    public int $id;
    public string $first_name;
    public string $middle_name;
    public string $last_name;
    public string $date_of_birth;
    public bool $is_eu_citizen;
    public bool $is_working;
    public string $housing_type;
    public string $program_type;
    public ?string $created_at;
    public ?string $updated_at;
}