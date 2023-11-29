<?php

declare(strict_types=1);

namespace App\Models;

class NewsCollection
{

    private array $newsCollection = [];

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

    public function isEmpty(): bool
    {
        return empty($this->newsCollection);
    }

    public function getAll(): array
    {
        return $this->newsCollection;
    }

    public function merge(NewsCollection $collection): void
    {
       $this->newsCollection = array_merge($this->newsCollection, $collection->getAll());
    }

}