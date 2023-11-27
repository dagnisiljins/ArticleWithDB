<?php

declare(strict_types=1);

namespace App\Services\Articles;

use App\Repositories\ArticleRepositoryInterface;
use App\Repositories\MysqlArticleRepository;
use http\Exception;

class DeleteArticleService
{
    private ArticleRepositoryInterface $articleRepository;
    public function __construct()
    {
        $this->articleRepository = new MysqlArticleRepository();
    }

    public function execute(int $id): void
    {
        $articleToDelete = $this->articleRepository->getByID($id);

        if ($articleToDelete === null) {
            throw new \Exception('Article not found for ID: ' . $id);
        }
        $this->articleRepository->delete($articleToDelete);
    }
}


