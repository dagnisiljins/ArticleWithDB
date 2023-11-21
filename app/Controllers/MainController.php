<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database\DatabaseConnection;
use App\Models\News;
use App\Models\NewsCollection;
use App\Response;
use App\Utils\NotificationManager;
use Carbon\Carbon;

class MainController
{
    private \PDO $db;
    public function __construct()
    {
        $this->db = DatabaseConnection::getInstance()->getConnection();
    }

    public function index(): Response
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

        return new Response(
            'news/index',
            ['articles' => $articles]
        );
    }

    public function show(array $vars): Response
    {
        $id = (int)$vars['id'];

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

        return new Response(
            'news/show',
            ['article' => $article]
        );
    }

    public function create(): Response
    {
        return new Response(
            'news/create',
            []
        );

    }

    public function store(): string // todo: respect/validation validate POST
    {
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $text = $_POST['text'] ?? '';



        $stmt = $this->db->prepare(
            "INSERT INTO articles (title, description, text, date) VALUES (:title, :description, :text, :date)"
        );
        $stmt->execute([
            'title' => $title,
            'description' => $description,
            'text' => $text,
            'date' => Carbon::now()
        ]);

        NotificationManager::setNotification("Article successfully created!", "success");

        header('Location: /');
        exit;
    }

    public function search(): Response
    {
        $title = $_GET['query'] ?? '';

        $stmt = $this->db->prepare("SELECT * FROM articles WHERE title LIKE :title");
        $stmt->execute(['title' => '%' . $title . '%']);

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

        return new Response(
            'news/index',
            ['articles' => $articles]
        );
    }

    public function edit(array $vars): Response
    {
        $editId = (int)$vars['id'];

        $stmt = $this->db->prepare("SELECT * FROM articles WHERE id = :id");
        $stmt->execute(['id' => $editId]);

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

        return new Response(
            'news/edit',
            ['article' => $article]
        );
    }

    public function update(): string
    {
        $id = $_POST['id'] ?? null;
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $text = $_POST['text'] ?? '';
        $updatedAt = Carbon::now();

        if ($id) {
            $stmt = $this->db->prepare(
                "UPDATE articles SET title = :title, description = :description, text = :text, updated_at = :updatedAt WHERE id = :id"
            );
            $stmt->execute([
                'title' => $title,
                'description' => $description,
                'text' => $text,
                'id' => $id,
                'updatedAt' => $updatedAt
            ]);
        }

        NotificationManager::setNotification("Article successfully edited!", "success");

        header('Location: /article/' . $id);
        exit;
    }

    public function delete(array $vars): string
    {
        $deleteId = (int)$vars['id'];

        $stmt = $this->db->prepare("DELETE FROM articles WHERE id = :id");
        $stmt->execute([
            'id' => $deleteId
        ]);

        NotificationManager::setNotification("Article successfully deleted!", "success");

        header('Location: /');//todo make interface Response and class ViewResponse and class RedirectResponse
        exit;
    }

}