<?php
declare(strict_types=1);

namespace F3\Mzgb\Application;


use F3\Mzgb\Application\ScoreBoard\Board;
use F3\Mzgb\Application\ScoreBoard\Row;
use F3\Mzgb\Game\Game;
use F3\Mzgb\Game\Score;
use F3\Mzgb\Game\Team;
use F3\Mzgb\Game\Tour;
use F3\Mzgb\Game\TourResult;
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
        $this->storage->createTeam($team);
        return $team->getId();
    }

    public function createGame(string $name): string
    {
        $game = new Game(Uuid::uuid4()->toString(), $name);
        $this->storage->createGame($game);
        return $game->getId();
    }

    public function createRegistration(string $team_id, string $game_id)
    {
        $team = $this->storage->getTeamById($team_id);
        $game = $this->storage->getGameById($game_id);
        $this->storage->createRegistration(new Registration($game, $team, new \DateTimeImmutable()));
    }

    public function getRegistrationList(string $game_id): array
    {
        $game = $this->storage->getGameById($game_id);
        $teams = $this->storage->getTeamsByGame($game);
        $dto = [
            'game' => $game->getName()
        ];
        foreach ($teams as $team) {
            $dto['teams'][] = $team->name();
        }
        return $dto;
    }

    public function savePoints(string $game_id, string $team_id, int $tour, array $points)
    {
        $game = $this->storage->getGameById($game_id);
        $team = $this->storage->getTeamById($team_id);
        $result = new TourResult(new Tour($tour), ...$points);
        $this->storage->saveTourResult($game, $team, $result);
    }

    public function getScoreBoard(string $game_id)
    {
        $game = $this->storage->getGameById($game_id);
        $teams = $this->storage->getTeamsByGame($game);
        $rows = [];
        foreach ($teams as $team) {
            $rows[] = new Row(
                $team->name(),
                new Score(...$this->storage->getResults($game, $team))
            );
        }
        $board = new Board(...$rows);
        $dto = [
            'game' => $game->getName(),
            'board' => [],
        ];

        foreach ($board->rowsSortedByRank() as $row) {
            $dto['board'][] = [
                'team' => $row->name(),
                'rank' => $row->rank($board),
                'score' => $row->total(),
                'tours' => $row->pointsByTour()
            ];
        }
        return $dto;
    }
}