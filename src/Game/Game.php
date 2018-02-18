<?php
declare(strict_types=1);

namespace F3\Mzgb\Game;

use F3\Mzgb\Game\Row;
use F3\Mzgb\Game\Score\CompareByRank;
use F3\Mzgb\Game\Score\HigherThan;
use F3\Mzgb\Game\Score\Score;

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
     * @var Score[]
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
        $this->scores[$team->toId()] = new Score($team, $this);
    }

    public function score(Team $team, int $tour, array $points): void
    {
        $this->scores[$team->toId()]->addPoints($tour, $points);
    }

    public function countScoresHigherThan(Score $score): int
    {
        return count(array_filter($this->scores, new HigherThan($score)));
    }

    public function toScoreBoard(): array
    {
        $scores = $this->scores;
        usort($scores, new CompareByRank());
        return $scores;
    }
}