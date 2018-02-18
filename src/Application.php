<?php
declare(strict_types=1);

namespace F3\MzgbServer;

use Ramsey\Uuid\Uuid;

class Application
{
    private $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function createTeam(string $name): string
    {
        $team = new Team(Uuid::uuid4()->toString(), $name);
        return $team->toId();
    }

    public function createGame(\DateTimeInterface $date, string $name)
    {
        $game = new Game(Uuid::uuid4()->toString(), $name, $date);
        return $game->toId();
    }

    public function register(string $team, string $game)
    {
    }

    public function score(string $game, int $tour, string $team, array $score)
    {
    }

    public function getTable(string $game): array
    {
        return [
            [
                'team' => 'Bar',
                'rank' => 1,
                'score' => 14,
                'tours' => [2, 2, 2, 2, 2, 2, 2]
            ],
            [
                'team' => 'Foo',
                'rank' => 2,
                'score' => 7,
                'tours' => [1, 1, 1, 1, 1, 1, 1]
            ],
        ];
    }
}