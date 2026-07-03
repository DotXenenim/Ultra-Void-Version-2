<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Step;
use App\Models\User;

interface StepRepositoryInterface
{
    /** @return Step[] */
    public function all(): array;

    /** @return Step[] */
    public function stepsForUser(User $user, array $alreadyHave = []): array;

    public function findBySlug(string $slug): ?Step;
}
