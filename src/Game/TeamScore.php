<?php
declare(strict_types=1);

namespace F3\MzgbServer\Game;

class TeamScore
{
    private $points = [];
    private $team;
    private $game;

    public function __construct(Team $team, Game $game)
    {
        $this->team = $team;
        $this->game = $game;
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

    public function toRank(): int
    {
        return $this->game->countScoresHigherThan($this) + 1;
    }

}