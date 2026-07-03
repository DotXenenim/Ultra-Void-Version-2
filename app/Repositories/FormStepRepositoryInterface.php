<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Step;

interface FormStepRepositoryInterface
{
    /** @param Step[] $steps */
    public function insertMany(int $formId, array $steps): void;

    /** @return Step[] */
    public function findByFormId(int $formId): array;

    public function toggle(int $formStepId, bool $completed): void;
}
