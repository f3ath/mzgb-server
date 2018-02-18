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

    public function createGame(\DateTimeInterface $date, string $name): string
    {
        $game = new Game(Uuid::uuid4()->toString(), $name, $date);
        $this->storage->persistGame($game);
        return $game->toId();
    }

    public function register(string $team_id, string $game_id): void
    {
    }

    public function score(string $game_id, int $tour, string $team_id, array $score): void
    {
        $game = $this->storage->getGame($game_id);
        $team = $this->storage->getTeam($team_id);
        if ($game && $team) {
            $game->registerTeam($team);
        }
    }

    public function getScoreBoard(string $game_id): array
    {
        $game = $this->storage->getGame($game_id);
        if (!$game) {
            throw new \OutOfBoundsException();
        }
        return array_map(
            function(ScoreBoardRow $row) {
                return [
                    'team' => $row->toTeamName(),
                    'rank' => $row->toRank(),
                    'score' => $row->toTotalScore(),
                    'tours' => $row->toScoreByTours()
                ];
            },
            $game->toScoreBoard()
        );
//        return [
//            [
//                'team' => 'Bar',
//                'rank' => 1,
//                'score' => 14,
//                'tours' => [2, 2, 2, 2, 2, 2, 2]
//            ],
//            [
//                'team' => 'Foo',
//                'rank' => 2,
//                'score' => 7,
//                'tours' => [1, 1, 1, 1, 1, 1, 1]
//            ],
//        ];
    }
}