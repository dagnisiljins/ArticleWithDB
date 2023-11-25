<?php

declare(strict_types=1);

namespace App\Services\Articles;

use App\Database\DatabaseConnection;
use App\Models\News;
use App\Models\NewsCollection;

class IndexArticleService
{
    private \PDO $db;
    public function __construct()
    {
        $this->db = DatabaseConnection::getInstance()->getConnection();
    }
    public function execute(): NewsCollection

    {
        $stmt = $this->db->query("SELECT * FROM articles");

        $articles = new NewsCollection();
        while ($row = $stmt->fetch()) {
            $articles->add(new News(
                $row['id'],
                $row['title'],
                $row['description'],
                $row['text'],
                $row['date']
            ));
        }

        return $articles;
    }







}