<?php

declare(strict_types=1);

namespace App\Services\Articles;

use App\Database\DatabaseConnection;

class DeleteArticleService
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = DatabaseConnection::getInstance()->getConnection();
    }

    public function execute(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM articles WHERE id = :id");
        $stmt->execute([
            'id' => $id
        ]);
    }
}


