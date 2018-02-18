<?php

namespace F3\Mzgb\Test;

use F3\Mzgb\Application\Application;
use F3\Mzgb\Application\Storage;
use F3\Mzgb\Game\Game;
use F3\Mzgb\Game\Team;
use PHPUnit\Framework\TestCase;

class InMemoryStorage implements Storage
{
    private $games = [];
    private $teams = [];

    public function getGame($game_id): ?Game
    {
        return $this->games[$game_id] ?? null;
    }

    public function getTeam($team_id): ?Team
    {
        return $this->teams[$team_id];
    }

    public function persistGame(Game $game): void
    {
        $this->games[$game->toId()] = $game;
    }

    public function persistTeam(Team $team): void
    {
        $this->teams[$team->toId()] = $team;
    }
}

class ApplicationTest extends TestCase
{
    public function testFullGame()
    {
        $app = new Application(new InMemoryStorage());
        $teamFoo = $app->createTeam('Foo');
        $teamBar = $app->createTeam('Bar');
        $date = new \DateTime('2018-02-24');
        $game = $app->createGame($date, 'Test Game');
        $app->register($teamFoo, $game);
        $app->register($teamBar, $game);

        $app->score($game, 1, $teamFoo, [1, 0, 0, 0, 0, 0, 0]); // 1
        $app->score($game, 2, $teamFoo, [0, 1, 0, 0, 0, 0, 0]); // 1
        $app->score($game, 3, $teamFoo, [0, 0, 1, 0, 0, 0, 0]); // 1
        $app->score($game, 4, $teamFoo, [0, 0, 0, 1, 0, 0, 0]); // 1
        $app->score($game, 5, $teamFoo, [0, 0, 0, 0, 1, 0, 0]); // 1
        $app->score($game, 6, $teamFoo, [0, 0, 0, 0, 0, 1, 0]); // 1
        $app->score($game, 7, $teamFoo, [1, 2, -2, 0, 0, 0, 0]); // 1
        // Total score: 7

        $app->score($game, 1, $teamBar, [1, 0, 0, 0, 0, 0, 1]); // 2
        $app->score($game, 2, $teamBar, [0, 1, 0, 0, 0, 0, 1]); // 2
        $app->score($game, 3, $teamBar, [0, 0, 1, 0, 0, 0, 1]); // 2
        $app->score($game, 4, $teamBar, [0, 0, 0, 1, 0, 0, 1]); // 2
        $app->score($game, 5, $teamBar, [0, 0, 0, 0, 1, 0, 1]); // 2
        $app->score($game, 6, $teamBar, [0, 0, 0, 0, 0, 1, 1]); // 2
        $app->score($game, 7, $teamBar, [1, 2, -2, 0, 0, 0, 1]); // 2
        // Total score: 14

        $board = $app->getScoreBoard($game);
        $this->assertEquals(
            [
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
            ],
            $board
        );

    }
}
