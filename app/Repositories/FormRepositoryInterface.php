<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Form;

interface FormRepositoryInterface
{
    public function findByUserId(int $userId): ?Form;

    public function insert(int $userId): Form;
}
