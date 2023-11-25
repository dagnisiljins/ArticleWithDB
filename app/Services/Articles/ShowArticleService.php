<?php

declare(strict_types=1);

namespace App\Services\Articles;

use App\Database\DatabaseConnection;
use App\Models\News;


class ShowArticleService
{
    private \PDO $db;
    public function __construct()
    {
        $this->db = DatabaseConnection::getInstance()->getConnection();
    }
    public function execute(int $id): News
    {
        $stmt = $this->db->prepare("SELECT * FROM articles WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $article = null;
        if ($row = $stmt->fetch()) {
            $article = new News(
                $row['id'],
                $row['title'],
                $row['description'],
                $row['text'],
                $row['date']
            );
        }

        return $article;
    }

}