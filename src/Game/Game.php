<?php
declare(strict_types=1);

namespace F3\MzgbServer\Game;

use F3\MzgbServer\Game\Row;

class Game
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var \DateTimeInterface
     */
    private $date;

    /**
     * @var TeamScore[]
     */
    private $scores = [];

    public function __construct(string $id, string $name, \DateTimeInterface $date)
    {
        $this->id = $id;
        $this->name = $name;
        $this->date = $date;
    }

    public function toId(): string
    {
        return $this->id;
    }

    public function register(Team $team): void
    {
        $this->scores[$team->toId()] = new TeamScore($team, $this);
    }

    public function score(Team $team, int $tour, array $points): void
    {
        $this->scores[$team->toId()]->score($tour, $points);
    }

    public function countScoresHigherThan(TeamScore $score): int
    {
        return count(array_filter($this->scores, new IsHigherThan($score)));
    }

    public function toScoreBoard(): array
    {
        $scores = $this->scores;
        usort($scores, new CompareByRank());
        return $scores;
    }
}