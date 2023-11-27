<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Database\DatabaseConnection;
use App\Models\News;
use App\Models\NewsCollection;
use Carbon\Carbon;

class ArticleRepository
{

    private \PDO $db;

    public function __construct()
    {
        $this->db = DatabaseConnection::getInstance()->getConnection();
    }

    public function getAll(): NewsCollection
    {

            $stmt = $this->db->query("SELECT * FROM articles");

            $articles = new NewsCollection();
            while ($row = $stmt->fetch()) {
                $articles->add(new News(
                    $row['title'],
                    $row['description'],
                    $row['text'],
                    $row['id'],
                    $row['date']
                ));
            }
            return $articles;
    }

    public function getByID(int $id): ?News
    {
        $stmt = $this->db->prepare("SELECT * FROM articles WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $article = null;
        if ($row = $stmt->fetch()) {
            $article = new News(
                $row['title'],
                $row['description'],
                $row['text'],
                $row['id'],
                $row['date']
            );
        }
        return $article;
    }

    public function save(News $news): void
    {
        if ($news->getId()) {
            $this->update($news);
            return;
        }

        $this->store($news);
    }

    public function searchByTitle(string $title): NewsCollection
    {
        $stmt = $this->db->prepare("SELECT * FROM articles WHERE title LIKE :title");
        $stmt->execute(['title' => '%' . $title . '%']);

        $articles = new NewsCollection();
        while ($row = $stmt->fetch()) {
            $articles->add(new News(
                $row['title'],
                $row['description'],
                $row['text'],
                $row['id'],
                $row['date']
            ));
        }
        return $articles;
    }

    public function delete(News $articleToDelete): void
    {
        $stmt = $this->db->prepare("DELETE FROM articles WHERE id = :id");
        $stmt->execute([
            'id' => $articleToDelete->getId()
        ]);
    }

    private function update(News $news): void
    {
        $stmt = $this->db->prepare(
            "UPDATE articles SET title = :title, description = :description, text = :text, updated_at = :updatedAt WHERE id = :id"
        );
        $stmt->execute([
            'title' => $news->getTitle(),
            'description' => $news->getDescription(),
            'text' => $news->getText(),
            'id' => $news->getId(),
            'updatedAt' => $news->getUpdatedAt()
        ]);
    }

    private function store(News $news): void
    {
        $stmt = $this->db->prepare(
            "INSERT INTO articles (title, description, text, date) VALUES (:title, :description, :text, :date)"
        );
        $stmt->execute([
            'title' => $news->getTitle(),
            'description' => $news->getDescription(),
            'text' => $news->getText(),
            'date' => Carbon::now()
        ]);
    }
}