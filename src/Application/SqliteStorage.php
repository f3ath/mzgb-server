<?php
declare(strict_types=1);

namespace F3\Mzgb\Application;

use F3\Mzgb\Game\Game;
use F3\Mzgb\Game\Score\TourResult;
use F3\Mzgb\Game\Team;
use F3\Mzgb\Game\Tour;

class SqliteStorage implements Storage
{
    private const DATE_FORMAT = \DateTime::RFC3339_EXTENDED;
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function install(): void
    {
        $commands = [
            'CREATE TABLE teams (id TEXT PRIMARY KEY, name TEXT UNIQUE )',
            'CREATE TABLE games (id TEXT PRIMARY KEY, name TEXT UNIQUE )',
            'CREATE TABLE registrations (game_id TEXT REFERENCES games(id), team_id TEXT REFERENCES teams(id), created TEXT)',
            'CREATE TABLE results (
              game_id TEXT REFERENCES games(id), 
              team_id TEXT REFERENCES teams(id), 
              tour INTEGER, 
              q1 INTEGER, q2 INTEGER, q3 INTEGER, q4 INTEGER, q5 INTEGER, q6 INTEGER, q7 INTEGER,
              PRIMARY KEY (game_id, team_id, tour)
            )',
        ];

        foreach ($commands as $command) {
            $this->pdo->exec($command);
        }
    }

    public function createTeam(Team $team): void
    {
        $insert = $this->pdo->prepare('INSERT INTO teams (id, name) VALUES(:id, :name)');
        $insert->execute([
            'id' => $team->getId(),
            'name' => $team->name()
        ]);
    }

    public function createGame(Game $game): void
    {
        $insert = $this->pdo->prepare(
            'INSERT INTO games (id, name) VALUES(:id, :name)'
        );
        $insert->execute([
            'id' => $game->getId(),
            'name' => $game->getName()
        ]);
    }

    public function getTeamById(string $id): ?Team
    {
        $select = $this->pdo->prepare(
            'SELECT * FROM teams WHERE id = :id'
        );
        $select->execute(['id' => $id]);
        $dto = $select->fetch(\PDO::FETCH_OBJ);
        return $dto ? new Team($dto->id, $dto->name) : null;
    }

    public function getGameById(string $id): ?Game
    {
        $select = $this->pdo->prepare(
            'SELECT * FROM games WHERE id = :id'
        );
        $select->execute(['id' => $id]);
        $dto = $select->fetch(\PDO::FETCH_OBJ);
        return $dto ? new Game($dto->id, $dto->name) : null;
    }

    public function createRegistration(Registration $reg): void
    {
        $insert = $this->pdo->prepare(
            'INSERT OR IGNORE INTO registrations (game_id, team_id, created) VALUES (:game_id, :team_id, :created)'
        );
        $insert->execute([
            'game_id' => $reg->toGameId(),
            'team_id' => $reg->toTeamId(),
            'created' => $reg->toCreationTime()->format(self::DATE_FORMAT),
        ]);
    }

    /**
     * @param Game $game
     * @return Team[]
     */
    public function getTeamsByGame(Game $game): array
    {
        $select = $this->pdo->prepare(
            'SELECT t.* FROM registrations r JOIN teams t ON r.team_id = t.id WHERE r.game_id = :game_id ORDER BY r.created ASC'
        );
        $select->execute(['game_id' => $game->getId()]);
        $teams = [];
        while ($t = $select->fetch(\PDO::FETCH_OBJ)) {
            $teams[] = new Team($t->id, $t->name);
        }
        return $teams;
    }

    public function saveTourResult(Game $game, Team $team, TourResult $points): void
    {
        $insert = $this->pdo->prepare(
            'REPLACE INTO results (game_id, team_id, tour, q1, q2, q3, q4, q5, q6, q7) 
            VALUES (:game_id, :team_id, :tour, :q1, :q2, :q3, :q4, :q5, :q6, :q7)'
        );
        [$q1, $q2, $q3, $q4, $q5, $q6, $q7] = $points->points();
        $insert->execute([
            'game_id' => $game->getId(),
            'team_id' => $team->getId(),
            'tour' => $points->tourNumber(),
            'q1' => $q1,
            'q2' => $q2,
            'q3' => $q3,
            'q4' => $q4,
            'q5' => $q5,
            'q6' => $q6,
            'q7' => $q7,
        ]);
    }

    /**
     * @param Game $game
     * @param Team $team
     * @return TourResult[]
     */
    public function getResults(Game $game, Team $team): array
    {
        $select= $this->pdo->prepare(
            'SELECT * FROM results WHERE game_id = :game_id AND team_id = :team_id ORDER BY tour'
        );
        $select->execute([
            'game_id' => $game->getId(),
            'team_id' => $team->getId(),
        ]);
        $results = [];
        while ($r = $select->fetch(\PDO::FETCH_OBJ)) {
            $results[] = new TourResult(
                new Tour((int)$r->tour), (int)$r->q1, (int)$r->q2, (int)$r->q3, (int)$r->q4, (int)$r->q5, (int)$r->q6, (int)$r->q7);
        }
        return $results;
    }
}