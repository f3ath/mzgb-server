<?php
declare(strict_types=1);

namespace F3\MzgbServer\Application;

use F3\MzgbServer\Game\Game;
use F3\MzgbServer\Game\Team;

interface Storage
{
    public function getGame($game_id): ?Game;

    public function getTeam($team_id): ?Team;

    public function persistGame(Game $game): void;

    public function persistTeam(Team $team): void;
}