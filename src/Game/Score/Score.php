<?php
declare(strict_types=1);

namespace F3\Mzgb\Game\Score;

use F3\Mzgb\Game\Game;
use F3\Mzgb\Game\Team;

class Score
{
    private $points = [];
    private $team;
    private $game;

    public function __construct(Team $team, Game $game)
    {
        $this->team = $team;
        $this->game = $game;
    }

    public function addPoints(int $tour, array $points): void
    {
        $this->points[$tour] = array_sum($points);
    }

    public function pointsByTour(): array
    {
        return $this->points;
    }

    public function isHigherThan(Score $that): bool
    {
        return $this->toPointsTotal() > $that->toPointsTotal();
    }

    public function toPointsTotal()
    {
        return array_sum($this->points);
    }

    public function toTeamName(): string
    {
        return $this->team->toName();
    }

    public function toRank(): int
    {
        return $this->game->countScoresHigherThan($this) + 1;
    }
}