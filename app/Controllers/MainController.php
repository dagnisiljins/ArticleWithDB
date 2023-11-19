<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database\DatabaseConnection;
use App\Models\News;
use App\Models\NewsCollection;
use App\Response;

class MainController
{

    public function index(): Response
    {
        $db = DatabaseConnection::getInstance()->getConnection();// todo put this in constructor
        $stmt = $db->query("SELECT * FROM articles");

        $articles = new NewsCollection();
        while ($row = $stmt->fetch()) {
            $articles->add(new News(
                $row['id'],
                $row['title'],
                $row['description'],
                $row['text']
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

        $db = DatabaseConnection::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM articles WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $article = null;
        if ($row = $stmt->fetch()) {
            $article = new News(
                $row['id'],
                $row['title'],
                $row['description'],
                $row['text']
            );
        }
        //dump($article);die;
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

    public function store(): string
    {
        //todo add $_SESSION text to inform that new article is added

        $db = DatabaseConnection::getInstance()->getConnection();

        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $text = $_POST['text'] ?? '';

        $stmt = $db->prepare("INSERT INTO articles (title, description, text) VALUES (:title, :description, :text)");
        $stmt->execute([
            'title' => $title,
            'description' => $description,
            'text' => $text
        ]);

        header('Location: /');
        exit;
    }

    public function search(): Response
    {
        $title = $_GET['query'] ?? '';

        $db = DatabaseConnection::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM articles WHERE title LIKE :title");
        $stmt->execute(['title' => '%' . $title . '%']);

        $articles = new NewsCollection();
        while ($row = $stmt->fetch()) {
            $articles->add(new News(
                $row['id'],
                $row['title'],
                $row['description'],
                $row['text']
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

        $db = DatabaseConnection::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM articles WHERE id = :id");
        $stmt->execute(['id' => $editId]);

        $article = null;
        if ($row = $stmt->fetch()) {
            $article = new News(
                $row['id'],
                $row['title'],
                $row['description'],
                $row['text']
            );
        }

        return new Response(
            'news/edit',
            ['article' => $article]
        );
    }

    public function update(): string
    {

        $db = DatabaseConnection::getInstance()->getConnection();

        $id = $_POST['id'] ?? null;
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $text = $_POST['text'] ?? '';

        if ($id) {
            $stmt = $db->prepare("UPDATE articles SET title = :title, description = :description, text = :text WHERE id = :id");
            $stmt->execute([
                'title' => $title,
                'description' => $description,
                'text' => $text,
                'id' => $id
            ]);
        }

        header('Location: /article/' . $id);
        exit;
    }

    public function delete(array $vars): string
    {
        $deleteId = (int)$vars['id'];

        $db = DatabaseConnection::getInstance()->getConnection();


        $stmt = $db->prepare("DELETE FROM articles WHERE id = :id");
        $stmt->execute([
            'id' => $deleteId
        ]);


        header('Location: /');
        exit;
    }


}