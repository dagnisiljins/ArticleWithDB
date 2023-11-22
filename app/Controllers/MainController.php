<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Response\RedirectResponse;
use App\Response\Response;
use App\Database\DatabaseConnection;
use App\Models\News;
use App\Models\NewsCollection;
use App\Response\ViewResponse;
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

        return new ViewResponse(
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

        return new ViewResponse(
            'news/show',
            ['article' => $article]
        );
    }

    public function create(): Response
    {
        return new ViewResponse(
            'news/create'
        );

    }

    public function store(): Response
    {
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $text = $_POST['text'] ?? '';

        $title = htmlspecialchars(trim($title));
        $description = htmlspecialchars(trim($description));
        $text = htmlspecialchars(trim($text));

        $stmt = $this->db->prepare(
            "INSERT INTO articles (title, description, text, date) VALUES (:title, :description, :text, :date)"
        );
        $stmt->execute([
            'title' => $title,
            'description' => $description,
            'text' => $text,
            'date' => Carbon::now()
        ]);

        $notification = [
            'message' => "Article successfully created!",
            'type' => "success"
        ];

        return new RedirectResponse('/', $notification);
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

        return new ViewResponse(
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

        return new ViewResponse(
            'news/edit',
            ['article' => $article]
        );
    }

    public function update(): Response
    {
        $id = $_POST['id'] ?? null;
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $text = $_POST['text'] ?? '';
        $updatedAt = Carbon::now();

        $title = htmlspecialchars(trim($title));
        $description = htmlspecialchars(trim($description));
        $text = htmlspecialchars(trim($text));

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

        $notification = [
            'message' => "Article successfully edited!",
            'type' => "success"
        ];

        return new RedirectResponse('/article/' . $id, $notification);

    }

    public function delete(array $vars): Response
    {
        $deleteId = (int)$vars['id'];

        $stmt = $this->db->prepare("DELETE FROM articles WHERE id = :id");
        $stmt->execute([
            'id' => $deleteId
        ]);

        $notification = [
            'message' => "Article successfully deleted!",
            'type' => "success"
        ];

        return new RedirectResponse('/', $notification);
    }

}