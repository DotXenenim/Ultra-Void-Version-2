<?php

declare(strict_types=1);

namespace App\Models;

class StepDependency
{
    public int $step_id;
    public int $depends_on_step_id;
}
