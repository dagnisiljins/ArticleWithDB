<?php

declare(strict_types=1);

namespace App\Models;

class News
{


    private string $title;
    private string $description;
    private string $url;
    private string $image;

    public function __construct(
        string $title,
        ?string $description,
        string $url,
        ?string $image
    )
    {

        $this->title = $title;
        $this->description = $description ?? 'No description';
        $this->url = $url;
        $this->image = $image ?? 'https://ajr.org/wp-content/themes/AJR-theme/images/news-placeholder.jpg';
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getImage(): string
    {
        return $this->image;
    }


}