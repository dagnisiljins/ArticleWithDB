<?php

declare(strict_types=1);

namespace App\Services\Articles;

use App\Database\DatabaseConnection;
use App\Models\News;
use App\Repositories\ArticleRepository;


class ShowArticleService
{
    private ArticleRepository $articleRepository;
    public function __construct()
    {
        $this->articleRepository = new ArticleRepository();
    }
    public function execute(int $id): News
    {
        return $this->articleRepository->getByID($id);
    }

}