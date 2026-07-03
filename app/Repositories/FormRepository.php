<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Form;
use Framework\Database;

class FormRepository implements FormRepositoryInterface
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function findByUserId(int $userId): ?Form
    {
        $row = $this->db->run(
            'SELECT * FROM forms WHERE user_id = :user_id',
            ['user_id' => $userId]
        )->fetch();

        if (!$row) {
            return null;
        }

        return $this->fromRow($row);
    }

    public function insert(int $userId): Form
    {
        $this->db->run(
            'INSERT INTO forms (user_id) VALUES (:user_id)',
            ['user_id' => $userId]
        );

        $form              = new Form();
        $form->id          = $this->db->getLastID();
        $form->user_id     = $userId;
        $form->submitted_at = date('Y-m-d H:i:s');

        return $form;
    }

    private function fromRow(mixed $row): Form
    {
        $form               = new Form();
        $form->id           = (int)$row->id;
        $form->user_id      = (int)$row->user_id;
        $form->submitted_at = $row->submitted_at;
        return $form;
    }
}
