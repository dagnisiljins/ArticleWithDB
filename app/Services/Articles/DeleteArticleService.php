<?php

declare(strict_types=1);

namespace App\Services\Articles;

use App\Repositories\ArticleRepository;
use http\Exception;

class DeleteArticleService
{
    private ArticleRepository $articleRepository;
    public function __construct()
    {
        $this->articleRepository = new ArticleRepository();
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


