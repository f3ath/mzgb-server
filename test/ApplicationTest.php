<?php

namespace F3\MzgbServer\Test;

use PHPUnit\Framework\TestCase;
use F3\MzgbServer\Application;

class ApplicationTest extends TestCase
{
    public function testFullGame()
    {
        $app = new Application();
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

        $table = $app->getTable($game);
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
            $table
        );

    }
}
