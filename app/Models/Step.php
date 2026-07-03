<?php

declare(strict_types=1);

namespace App\Models;

class Step
{
    public int $id;
    public string $slug;
    public string $title;
    public string $description;
    public ?string $detail              = null;
    public ?string $official_url        = null;
    public ?string $official_url_label  = null;
    public ?string $icon               = null;
    public int $sort_order             = 0;
    public bool $applies_to_eu         = true;
    public bool $applies_to_non_eu     = true;
    public ?bool $requires_working     = null;
    public ?string $requires_housing   = null;
    public ?string $requires_program   = null;
    public ?int $requires_age_max      = null;
    public ?string $optional_suggestion = null;
    // runtime fields
    public bool $completed             = false;
    public ?string $completed_at       = null;
    public int $form_step_id           = 0;
}
