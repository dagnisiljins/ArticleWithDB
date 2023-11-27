<?php

declare(strict_types=1);

namespace App\Services\Articles;

use App\Models\News;
use App\Repositories\ArticleRepositoryInterface;
use App\Repositories\MysqlArticleRepository;


class UpdateArticleService
{
    private ArticleRepositoryInterface $articleRepository;
    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
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