<?php
declare(strict_types=1);

namespace F3\Mzgb\Application;

use F3\Mzgb\Game\Game;
use F3\Mzgb\Game\Team;
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
        $this->storage->persistTeam($team);
        return $team->toId();
    }

    public function createGame(\DateTimeInterface $date, string $name): string
    {
        $game = new Game(Uuid::uuid4()->toString(), $name, $date);
        $this->storage->persistGame($game);
        return $game->toId();
    }

    public function register(string $team_id, string $game_id): void
    {
        $game = $this->storage->getGame($game_id);
        $team = $this->storage->getTeam($team_id);
        $game->register($team);
    }

    public function score(string $game_id, int $tour, string $team_id, array $score): void
    {
        $game = $this->storage->getGame($game_id);
        $team = $this->storage->getTeam($team_id);
        $game->score($team, $tour, $score);
    }

    public function getScoreBoard(string $game_id): array
    {
        $game = $this->storage->getGame($game_id);
        return array_map(new ScoreToArrayMapper(), $game->toScoreBoard());
    }
}