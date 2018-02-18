<?php
declare(strict_types=1);

namespace F3\MzgbServer;

class Team
{
    private $name;
    private $id;

    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function toId(): string
    {
        return $this->id;
    }

    public function toName(): string
    {
        return $this->name;
    }
}