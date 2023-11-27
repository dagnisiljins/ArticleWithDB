<?php

declare(strict_types=1);

namespace App\Services\Articles;

use App\Models\NewsCollection;
use App\Repositories\ArticleRepository;

class IndexArticleService
{
    private ArticleRepository $articleRepository;
    public function __construct()
    {
        $this->articleRepository = new ArticleRepository();
    }
    public function execute(): NewsCollection
    {


        return $this->articleRepository->getAll();
    }







}