<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\News;
use App\Models\NewsCollection;

class CombinedArticleRepository implements ArticleRepositoryInterface
{
    private MysqlArticleRepository $mysqlArticleRepository;
    private NewsAPIArticleRepository $newsAPIArticleRepository;

    public function __construct(
        MysqlArticleRepository   $mysqlArticleRepository,
        NewsAPIArticleRepository $newsAPIArticleRepository
    )
    {
        $this->mysqlArticleRepository = $mysqlArticleRepository;
        $this->newsAPIArticleRepository = $newsAPIArticleRepository;
    }

    public function getAll(): NewsCollection
    {
        $apiArticles = $this->newsAPIArticleRepository->getAll();
        $articles = $this->mysqlArticleRepository->getAll();

        $articles->merge($apiArticles);
        return $articles;
    }

    public function getByID(int $id): ?News
    {
        return $this->mysqlArticleRepository->getByID($id);
    }

    public function save(News $news): void
    {
        $this->mysqlArticleRepository->save($news);
    }

    public function searchByTitle(string $title): NewsCollection
    {
        $apiArticles = $this->newsAPIArticleRepository->searchByTitle($title);
        $articles = $this->mysqlArticleRepository->searchByTitle($title);

        $articles->merge($apiArticles);
        return $articles;
    }

    public function delete(News $articleToDelete): void
    {
        $this->mysqlArticleRepository->delete($articleToDelete);
    }
}