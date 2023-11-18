<?php

declare(strict_types=1);

namespace App;

class Response
{
    private string $viewName;
    private array $data;

    public function __construct(string $viewName, array $data)
    {
        $this->viewName = $viewName;
        $this->data = $data;
    }

    public function getViewName(): string
    {
        return $this->viewName;
    }

    public function getData(): array
    {
        return $this->data;
    }
}