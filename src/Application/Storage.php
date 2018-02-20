<?php
declare(strict_types=1);

namespace F3\Mzgb\Application;

use F3\Mzgb\Game\Game;
use F3\Mzgb\Game\Team;
use F3\Mzgb\Game\TourResult;

interface Storage
{
    public function install(): void;

    public function createTeam(Team $team): void;

    public function createGame(Game $game): void;

    public function getTeamById(string $id): ?Team;

    public function getGameById(string $id): ?Game;

    public function createRegistration(Registration $param): void;

    /**
     * @param Game $game
     * @return Team[]
     */
    public function getTeamsByGame(Game $game): array;

    public function saveTourResult(Game $game, Team $team, TourResult $points): void;

    /**
     * @param Game $game
     * @param Team $team
     * @return TourResult[]
     */
    public function getResults(Game $game, Team $team): array;
}