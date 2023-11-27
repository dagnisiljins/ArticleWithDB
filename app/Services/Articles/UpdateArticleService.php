<?php

declare(strict_types=1);

namespace App\Services\Articles;

use App\Models\News;
use App\Repositories\ArticleRepository;


class UpdateArticleService
{
    private ArticleRepository $articleRepository;
    public function __construct()
    {
        $this->articleRepository = new ArticleRepository();
    }

    public function execute(string $title, string $description, string $text, int $id): void
    {
        $article = $this->articleRepository->getByID($id);

        $article->update([
            'title' => $title,
            'description' => $description,
            'text' => $text
        ]);

        $this->articleRepository->save($article);

    }
}