<?php

namespace App\Models;

class User
{
    public int $id;
    public string $first_name;
    public string $middle_name;
    public string $last_name;
    public int $date_of_birth;
    public bool $is_eu_citizen;
    public bool $will_work;
    public string $housing_type;
    public string $program_type;
    public int $created_at;
    public int $updated_at;
}