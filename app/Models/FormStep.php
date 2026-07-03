<?php

declare(strict_types=1);

namespace App\Models;

class FormStep
{
    public int $id;
    public int $form_id;
    public int $step_id;
    public bool $completed    = false;
    public ?string $completed_at = null;
}
