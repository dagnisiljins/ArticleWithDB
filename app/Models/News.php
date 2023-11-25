<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;

class News
{


    private ?int $id;
    private string $title;
    private string $description;
    private string $text;
    private string $date;
    private ?Carbon $updatedAt;


    public function __construct(
        ?int    $id,
        string $title,
        string $description,
        string $text,
        string $date ,
        ?Carbon $updatedAt = null
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->text = $text;
        $this->date = $date;
        $this->updatedAt =$updatedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->updatedAt;
    }


}