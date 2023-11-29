<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Database\NewsApi;
use App\Models\News;
use App\Models\NewsCollection;

class NewsAPIArticleRepository implements ArticleRepositoryInterface
{
    private NewsApi $newsApi;

    public function __construct()
    {
        $this->newsApi = new NewsApi();
    }

    public function getAll(string $title = null): NewsCollection
    {
        $newsData = $this->newsApi->fetchNews();
        $articles = new NewsCollection();

        foreach ($newsData->articles as $news) {

            if ($title !== null && strpos(strtolower($news->title), strtolower($title)) === false) {
                continue;
            }
            $articles->add(new News(
                $news->title,
                $news->description,
                $news->description,
                null,
                $news->publishedAt,
                null,
                $news->url,
            ));
        }

        return $articles;
    }

    public function getByID(int $id): ?News
    {
        return null;
    }

    public function save(News $news): void {}

    public function searchByTitle(string $title): NewsCollection
    {
        return $this->getAll($title);
    }

    public function delete(News $articleToDelete): void {}
}