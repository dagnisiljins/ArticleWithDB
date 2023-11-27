<?php

declare(strict_types=1);

namespace App\Services\Articles;

use App\Models\News;
use App\Repositories\ArticleRepositoryInterface;
use App\Repositories\MysqlArticleRepository;


class StoreArticleService
{
    private ArticleRepositoryInterface $articleRepository;
    /*public function __construct()
    {
        $this->articleRepository = new MysqlArticleRepository();
    }*/
    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function execute($article): void
    {
        $this->articleRepository->save($article);
    }
}