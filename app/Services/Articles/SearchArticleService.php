<?php

declare(strict_types=1);

namespace App\Services\Articles;

use App\Models\NewsCollection;
use App\Repositories\ArticleRepositoryInterface;
use App\Repositories\MysqlArticleRepository;


class SearchArticleService
{
    private ArticleRepositoryInterface $articleRepository;
    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function execute(string $title): NewsCollection
    {
        return $this->articleRepository->searchByTitle($title);
    }
}