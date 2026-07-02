<?php

namespace App\Models;

class Step
{
    public int $id;

    public string $title;

    public string $description;

    public string $official_url;

    public bool $applies_to_eu;

    public int $requires_age;

    public bool $requires_work;

    public string $requires_housing_type;
}