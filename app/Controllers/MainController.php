<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Response\RedirectResponse;
use App\Response\Response;
use App\Response\ViewResponse;
use App\Services\Articles\DeleteArticleService;
use App\Services\Articles\IndexArticleService;
use App\Services\Articles\SearchArticleService;
use App\Services\Articles\ShowArticleService;
use App\Services\Articles\StoreArticleService;
use App\Services\Articles\UpdateArticleService;

class MainController
{

    public function index(): Response
    {
        $service = new IndexArticleService();
        $articles = $service->execute();

        return new ViewResponse(
            'news/index',
            ['articles' => $articles]
        );
    }

    public function show(array $vars): Response
    {
        $id = (int)$vars['id'];

        $service = new ShowArticleService();
        $article = $service->execute($id);

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
        $title = htmlspecialchars(trim($_POST['title']));
        $description = htmlspecialchars(trim($_POST['description']));
        $text = htmlspecialchars(trim($_POST['text']));

        $store = new StoreArticleService();
        $store->execute($title, $description, $text);

        $notification = [
            'message' => "Article successfully created!",
            'type' => "success"
        ];

        return new RedirectResponse('/', $notification);
    }

    public function search(): Response
    {
        $title = $_GET['query'] ?? '';
        $service = new SearchArticleService();
        $articles = $service->execute($title);

        return new ViewResponse(
            'news/index',
            ['articles' => $articles]
        );
    }

    public function edit(array $vars): Response
    {
        $id = (int)$vars['id'];

        $service = new ShowArticleService();
        $article = $service->execute($id);

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

        $title = htmlspecialchars(trim($title));
        $description = htmlspecialchars(trim($description));
        $text = htmlspecialchars(trim($text));

        $store = new UpdateArticleService();
        $store->execute($title, $description, $text, (int)$id);

        $notification = [
            'message' => "Article successfully edited!",
            'type' => "success"
        ];

        return new RedirectResponse('/article/' . $id, $notification);

    }

    public function delete(array $vars): Response
    {
        $id = (int)$vars['id'];

        $service = new DeleteArticleService();
        $service->execute($id);

        $notification = [
            'message' => "Article successfully deleted!",
            'type' => "success"
        ];

        return new RedirectResponse('/', $notification);
    }

}