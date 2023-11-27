<?php

declare(strict_types=1);

namespace App\Services\Articles;

use App\Models\News;
use App\Repositories\ArticleRepositoryInterface;
use App\Repositories\MysqlArticleRepository;


class StoreArticleService
{
    private ArticleRepositoryInterface $articleRepository;
    public function __construct()
    {
        $this->articleRepository = new MysqlArticleRepository();
    }

    public function execute(string $title, string $description, string $text, int $id = null): void
    {
        $article = new News(
            $title,
            $description,
            $text,
            $id
        );

        $this->articleRepository->save($article);

    }
}