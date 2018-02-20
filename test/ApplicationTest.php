<?php

namespace F3\Mzgb\Test;

use F3\Mzgb\Application\Application;
use F3\Mzgb\Application\SqliteStorage;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    private $db;

    protected function setUp()
    {
        $this->db = tempnam(sys_get_temp_dir(), 'php');
        $this->getStorage()->install();
    }

    protected function tearDown()
    {
        unlink($this->db);
    }

    public function testRegistrationList()
    {
        $teamFoo = $this->getApp()->createTeam('Foo');
        $teamBar = $this->getApp()->createTeam('Bar');
        $game = $this->getApp()->createGame('Test Game');
        $this->getApp()->createRegistration($teamFoo, $game);
        $this->getApp()->createRegistration($teamBar, $game);

        $reg_list = $this->getApp()->getRegistrationList($game);

        $this->assertEquals(
            [
                'game' => 'Test Game',
                'teams' => [
                    'Foo',
                    'Bar'
                ]
            ],
            $reg_list
        );
    }

    public function testFullGame()
    {
        $teamFoo = $this->getApp()->createTeam('Foo');
        $teamBar = $this->getApp()->createTeam('Bar');
        $game_id = $this->getApp()->createGame('Test Game');

        $this->getApp()->createRegistration($teamFoo, $game_id);
        $this->getApp()->createRegistration($teamBar, $game_id);

        $this->assertNotEmpty($this->getApp()->getScoreBoard($game_id));

        $this->getApp()->savePoints($game_id, $teamFoo, 1, [1, 0, 0, 0, 0, 0, 0]); // 1
        $this->getApp()->savePoints($game_id, $teamFoo, 2, [0, 1, 0, 0, 0, 0, 0]); // 1
        $this->getApp()->savePoints($game_id, $teamFoo, 3, [0, 0, 1, 0, 0, 0, 0]); // 1

        $this->getApp()->savePoints($game_id, $teamBar, 1, [1, 0, 0, 0, 0, 0, 1]); // 2
        $this->getApp()->savePoints($game_id, $teamBar, 2, [0, 1, 0, 0, 0, 0, 1]); // 2
        $this->getApp()->savePoints($game_id, $teamBar, 3, [0, 0, 1, 0, 0, 0, 1]); // 2

        $this->assertEquals(
            [
                'game' => 'Test Game',
                'board' => [
                    [
                        'team' => 'Bar',
                        'rank' => 1,
                        'score' => 6,
                        'tours' => [1 => 2, 2 => 2, 3 => 2]
                    ],
                    [
                        'team' => 'Foo',
                        'rank' => 2,
                        'score' => 3,
                        'tours' => [1 => 1, 2 => 1, 3 => 1]
                    ],
                ]
            ],
            $this->getApp()->getScoreBoard($game_id)
        );

        $this->getApp()->savePoints($game_id, $teamFoo, 4, [0, 0, 0, 1, 0, 0, 1]); // 2
        $this->getApp()->savePoints($game_id, $teamFoo, 5, [0, 0, 0, 0, 1, 0, 1]); // 2
        $this->getApp()->savePoints($game_id, $teamFoo, 6, [0, 0, 0, 0, 0, 1, 1]); // 2

        $this->getApp()->savePoints($game_id, $teamBar, 4, [0, 0, 0, 1, 0, 0, 0]); // 1
        $this->getApp()->savePoints($game_id, $teamBar, 5, [0, 0, 0, 0, 1, 0, 0]); // 1
        $this->getApp()->savePoints($game_id, $teamBar, 6, [0, 0, 0, 0, 0, 1, 0]); // 1

        $this->assertEquals(
            [
                'game' => 'Test Game',
                'board' => [
                    [
                        'team' => 'Foo',
                        'rank' => 1,
                        'score' => 9,
                        'tours' => [1 => 1, 2 => 1, 3 => 1, 4 => 2, 5 => 2, 6 => 2]
                    ],
                    [
                        'team' => 'Bar',
                        'rank' => 2,
                        'score' => 9,
                        'tours' => [1 => 2, 2 => 2, 3 => 2, 4 => 1, 5 => 1, 6 => 1]
                    ],
                ]
            ],
            $this->getApp()->getScoreBoard($game_id)
        );

        $this->getApp()->savePoints($game_id, $teamFoo, 7, [1, 2, -2, 0, 0, 0, 0]); // 1
        $this->getApp()->savePoints($game_id, $teamBar, 7, [1, 2, -2, 0, 0, 0, 1]); // 2

        $this->assertEquals(
            [
                'game' => 'Test Game',
                'board' => [
                    [
                        'team' => 'Bar',
                        'rank' => 1,
                        'score' => 11,
                        'tours' => [1 => 2, 2 => 2, 3 => 2, 4 => 1, 5 => 1, 6 => 1, 7 => 2]
                    ],
                    [
                        'team' => 'Foo',
                        'rank' => 2,
                        'score' => 10,
                        'tours' => [1 => 1, 2 => 1, 3 => 1, 4 => 2, 5 => 2, 6 => 2, 7 => 1]
                    ],
                ]
            ],
            $this->getApp()->getScoreBoard($game_id)
        );

    }

    private function getApp(): Application
    {
        return new Application(
            $this->getStorage()
        );
    }

    /**
     * @return SqliteStorage
     */
    private function getStorage(): SqliteStorage
    {
        return new SqliteStorage(
            new \PDO("sqlite:{$this->db}", null, null, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION])
        );
    }
}
