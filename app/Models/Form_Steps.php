<?php

namespace App\Models;

class Form_Steps
{
    public int $id;

    public int $form_id;

    public int $step_id;

    public bool $completed;

    public int $completed_at;
}