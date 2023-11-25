<?php

declare(strict_types=1);

namespace App\Services\Articles;

use App\Database\DatabaseConnection;
use Carbon\Carbon;


class StoreArticleService
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = DatabaseConnection::getInstance()->getConnection();
    }

    public function execute(string $title, string $description, string $text, int $id = null): void
    {

        if ($id !== null) {
            $stmt = $this->db->prepare(
                "UPDATE articles SET title = :title, description = :description, text = :text, updated_at = :updatedAt WHERE id = :id"
            );
            $stmt->execute([
                'title' => $title,
                'description' => $description,
                'text' => $text,
                'id' => $id,
                'updatedAt' => Carbon::now()
            ]);
        } else {
            $stmt = $this->db->prepare(
                "INSERT INTO articles (title, description, text, date) VALUES (:title, :description, :text, :date)"
            );
            $stmt->execute([
                'title' => $title,
                'description' => $description,
                'text' => $text,
                'date' => Carbon::now()
            ]);
        }

    }
}