<?php
declare(strict_types=1);

namespace F3\Mzgb\Game;

class Team
{
    private $name;
    private $id;

    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }
}