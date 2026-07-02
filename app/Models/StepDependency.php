<?php

namespace App\Models;

class StepDependency
{
    public int $stepId;
    public int $dependsOnStepId;
}