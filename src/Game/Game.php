<?php
declare(strict_types=1);

namespace F3\Mzgb\Game;

class Game
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $name;

    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}