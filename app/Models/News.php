<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;

class News
{


    private string $title;
    private ?string $description;
    private ?string $text;
    private ?int $id;
    private ?string $date;
    private ?Carbon $updatedAt;
    private ?string $url;


    public function __construct(
        string  $title,
        ?string  $description,
        ?string  $text,
        ?int    $id = null,
        ?string $date = null,
        ?Carbon $updatedAt = null,
        ?string $url = null
    )
    {
        $this->title = $title;
        $this->description = $description;
        $this->text = $text;
        $this->id = $id;
        $this->date = $date;
        $this->updatedAt = $updatedAt ? new Carbon($updatedAt) : null;
        $this->url = $url;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->updatedAt;
    }
     public function getUrl(): ?string
     {
         return $this->url;
     }

    public function update(array $data): void
    {
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->text = $data['text'];
        $this->updatedAt = Carbon::now();
    }


}