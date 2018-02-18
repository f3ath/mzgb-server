<?php
declare(strict_types=1);

namespace F3\MzgbServer;

class TeamScore
{
    private $points = [];
    private $team;

    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    public function score(int $tour, array $points): void
    {
        $this->points[$tour] = array_sum($points);
    }

    public function pointsByTour(): array
    {
        return $this->points;
    }

    public function total()
    {
        return array_sum($this->points);
    }

    public function isHigherThan(TeamScore $that): bool
    {
        return $this->total() > $that->total();
    }

    public function toTeamName(): string
    {
        return $this->team->toName();
    }
}