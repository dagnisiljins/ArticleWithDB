<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\News;
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
    private IndexArticleService $articleService;
    private ShowArticleService $showArticleService;
    private StoreArticleService $storeArticleService;
    private SearchArticleService $searchArticleService;
    private UpdateArticleService $updateArticleService;
    private DeleteArticleService $deleteArticleService;

    public function __construct(
        IndexArticleService  $articleService,
        ShowArticleService   $showArticleService,
        StoreArticleService  $storeArticleService,
        SearchArticleService $searchArticleService,
        UpdateArticleService $updateArticleService,
        DeleteArticleService $deleteArticleService
    )
    {
        $this->articleService = $articleService;
        $this->showArticleService = $showArticleService;
        $this->storeArticleService = $storeArticleService;
        $this->searchArticleService = $searchArticleService;
        $this->updateArticleService = $updateArticleService;
        $this->deleteArticleService = $deleteArticleService;
    }

    public function index(): Response
    {
        /*$service = new IndexArticleService();
        $articles = $service->execute();*/

        $articles = $this->articleService->execute();

        return new ViewResponse(
            'news/index',
            ['articles' => $articles]
        );
    }

    public function show(array $vars): Response
    {
        $id = (int)$vars['id'];

        /*$service = new ShowArticleService();
        $article = $service->execute($id);*/

        $article = $this->showArticleService->execute($id);

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

        $article = new News(
            $title,
            $description,
            $text
        );

        $this->storeArticleService->execute($article);

        $notification = [
            'message' => "Article successfully created!",
            'type' => "success"
        ];

        return new RedirectResponse('/', $notification);
    }

    public function search(): Response
    {
        $title = $_GET['query'] ?? '';
        /*$service = new SearchArticleService();
        $articles = $service->execute($title);*/

        $articles = $this->searchArticleService->execute($title);

        return new ViewResponse(
            'news/index',
            [
                'articles' => $articles,
                'search' => $title,
            ]
        );
    }

    public function edit(array $vars): Response
    {
        $id = (int)$vars['id'];

        $article = $this->showArticleService->execute($id);

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

        /*$store = new UpdateArticleService();
        $store->execute($title, $description, $text, (int)$id);*/
        $this->updateArticleService->execute($title, $description, $text, (int)$id);

        $notification = [
            'message' => "Article successfully edited!",
            'type' => "success"
        ];

        return new RedirectResponse('/article/' . $id, $notification);

    }

    public function delete(array $vars): Response
    {
        $id = (int)$vars['id'];
        $this->deleteArticleService->execute($id);

        $notification = [
            'message' => "Article successfully deleted!",
            'type' => "success"
        ];

        return new RedirectResponse('/', $notification);
    }

}