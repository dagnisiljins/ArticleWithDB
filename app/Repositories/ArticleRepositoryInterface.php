<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\News;
use App\Models\NewsCollection;

interface ArticleRepositoryInterface
{

    public function getAll(): NewsCollection;
    public function getByID(int $id): ?News;
    public function save(News $news): void;
    public function searchByTitle(string $title): NewsCollection;
    public function delete(News $articleToDelete): void;

}