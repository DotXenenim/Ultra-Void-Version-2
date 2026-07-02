<?php

namespace App\Models;

class Step
{
    public int $id;
    public string $title;
    public ?string $description;
    public ?string $officialUrl;
    public ?bool $appliesToEu;
    public ?int $requiresAge;
    public ?bool $requiresWork;
    public ?string $requiresHousingType;
}