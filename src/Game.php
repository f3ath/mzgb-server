<?php
declare(strict_types=1);

namespace F3\MzgbServer;


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
    /**
     * @var \DateTimeInterface
     */
    private $date;

    public function __construct(string $id, string $name, \DateTimeInterface $date)
    {
        $this->id = $id;
        $this->name = $name;
        $this->date = $date;
    }

    public function toId(): string
    {
        return $this->id;
    }

    public function toScoreBoard(): array
    {
        return [
            new ScoreBoardRow('Bar', 1, [2, 2, 2, 2, 2, 2, 2]),
            new ScoreBoardRow('Foo', 2, [1, 1, 1, 1, 1, 1, 1]),
        ];
    }
}