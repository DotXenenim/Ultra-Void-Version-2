<?php

namespace App\Models;

class FormStep
{
    public int $id;
    public int $formId;
    public int $stepId;
    public bool $completed;
    public ?string $completedAt;
}