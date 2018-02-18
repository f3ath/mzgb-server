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
}