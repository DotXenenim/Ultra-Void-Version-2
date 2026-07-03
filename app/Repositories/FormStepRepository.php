<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Step;
use Framework\Database;

class FormStepRepository implements FormStepRepositoryInterface
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function insertMany(int $formId, array $steps): void
    {
        foreach ($steps as $step) {
            $this->db->run(
                'INSERT INTO form_steps (form_id, step_id, completed)
                 VALUES (:form_id, :step_id, 0)',
                ['form_id' => $formId, 'step_id' => $step->id]
            );
        }
    }

    public function findByFormId(int $formId): array
    {
        $rows = $this->db->run(
            'SELECT s.*, fs.id AS form_step_id, fs.completed, fs.completed_at
             FROM form_steps fs
             JOIN steps s ON s.id = fs.step_id
             WHERE fs.form_id = :form_id
             ORDER BY s.sort_order',
            ['form_id' => $formId]
        )->fetchAll();

        $steps = [];
        foreach ($rows as $row) {
            $step               = $this->fromRow($row);
            $step->form_step_id = (int)$row->form_step_id;
            $step->completed    = (bool)$row->completed;
            $step->completed_at = $row->completed_at;
            $steps[] = $step;
        }

        return $steps;
    }

    public function toggle(int $formStepId, bool $completed): void
    {
        $this->db->run(
            'UPDATE form_steps
             SET completed = :completed, completed_at = :completed_at
             WHERE id = :id',
            [
                'completed'    => (int)$completed,
                'completed_at' => $completed ? date('Y-m-d H:i:s') : null,
                'id'           => $formStepId,
            ]
        );
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
