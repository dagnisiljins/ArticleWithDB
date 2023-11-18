<?php

declare(strict_types=1);

namespace App\Models;

class NewsCollection
{

    private array $newsCollection;

    public function __construct(array $newsCollection = [])
    {
        foreach ($newsCollection as $news) {
            $this->add($news);
        }
    }

    public function add(News $news)
    {
        $this->newsCollection [] = $news;
    }
    public function getNewsCollection(): array
    {
        return $this->newsCollection;
    }

}