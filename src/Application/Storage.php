<?php
declare(strict_types=1);

namespace F3\Mzgb\Application;

use F3\Mzgb\Game\Game;
use F3\Mzgb\Game\Team;

interface Storage
{
    public function getGame($game_id): ?Game;

    public function getTeam($team_id): ?Team;

    public function persistGame(Game $game): void;

    public function persistTeam(Team $team): void;
}