<?php

declare(strict_types=1);

namespace App\Models;

class News
{


    private int $id;
    private string $title;
    private string $description;
    private string $text;


    public function __construct(
        int $id,
        string $title,
        string $description,
        string $text
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->text = $text;
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


}