<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Step;
use App\Models\User;
use Framework\Database;

class StepRepository implements StepRepositoryInterface
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function all(): array
    {
        $rows = $this->db->run('SELECT * FROM steps ORDER BY sort_order')->fetchAll();
        return array_map([$this, 'fromRow'], $rows);
    }

    public function findBySlug(string $slug): ?Step
    {
        $row = $this->db->run(
            'SELECT * FROM steps WHERE slug = :slug',
            ['slug' => $slug]
        )->fetch();
        return $row ? $this->fromRow($row) : null;
    }

    public function stepsForUser(User $user, array $alreadyHave = []): array
    {
        $rows = $this->db->run('SELECT * FROM steps ORDER BY sort_order')->fetchAll();
        $steps = [];

        $age = null;
        if ($user->date_of_birth) {
            $dob = new \DateTime($user->date_of_birth);
            $age = (int)(new \DateTime())->diff($dob)->y;
        }

        foreach ($rows as $row) {
            $step = $this->fromRow($row);

            if (in_array($step->slug, $alreadyHave, true)) {
                continue;
            }
            if ($user->is_eu === true && !$step->applies_to_eu) {
                continue;
            }
            if ($user->is_eu === false && !$step->applies_to_non_eu) {
                continue;
            }
            if ($step->requires_working !== null && $user->is_working !== null) {
                if ((bool)$step->requires_working !== (bool)$user->is_working) {
                    continue;
                }
            }
            if ($step->requires_housing !== null) {
                if ($user->housing_type !== $step->requires_housing) {
                    continue;
                }
            }
            if ($step->requires_program !== null) {
                $allowed = array_map('trim', explode(',', $step->requires_program));
                if ($user->program_type !== null && !in_array($user->program_type, $allowed, true)) {
                    continue;
                }
            }
            if ($step->requires_age_max !== null && $age !== null) {
                if ($age >= $step->requires_age_max) {
                    continue;
                }
            }

            $steps[] = $step;
        }

        return $steps;
    }

    private function fromRow(mixed $row): Step
    {
        $step                     = new Step();
        $step->id                 = (int)$row->id;
        $step->slug               = $row->slug;
        $step->title              = $row->title;
        $step->description        = $row->description;
        $step->detail             = $row->detail;
        $step->official_url       = $row->official_url;
        $step->official_url_label = $row->official_url_label;
        $step->icon               = $row->icon;
        $step->sort_order         = (int)$row->sort_order;
        $step->applies_to_eu      = (bool)$row->applies_to_eu;
        $step->applies_to_non_eu  = (bool)$row->applies_to_non_eu;
        $step->requires_working   = $row->requires_working === null ? null : (bool)$row->requires_working;
        $step->requires_housing   = $row->requires_housing;
        $step->requires_program   = $row->requires_program;
        $step->requires_age_max   = $row->requires_age_max === null ? null : (int)$row->requires_age_max;
        $step->optional_suggestion = $row->optional_suggestion;
        return $step;
    }
}
