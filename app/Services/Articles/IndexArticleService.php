<?php

declare(strict_types=1);

namespace App\Services\Articles;

use App\Models\NewsCollection;
use App\Repositories\ArticleRepositoryInterface;
use App\Repositories\MysqlArticleRepository;

class IndexArticleService
{
    private ArticleRepositoryInterface $articleRepository;
    public function __construct()
    {
        $this->articleRepository = new MysqlArticleRepository();
    }
    public function execute(): NewsCollection
    {

        return $this->articleRepository->getAll();
    }

}