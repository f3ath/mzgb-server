<?php
declare(strict_types=1);

namespace F3\Mzgb\Application\ScoreBoard;

use F3\Mzgb\Game\Score\Score;

class Row
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var Score
     */
    private $score;

    public function __construct(string $name, Score $score)
    {
        $this->name = $name;
        $this->score = $score;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function hasHigherScoreThan(Row $row): bool
    {
        return $this->score->isHigherThan($row->score);
    }

    public function rank(Board $board): int
    {
        return $board->countRowsHigherThan($this) + 1;
    }

    public function total(): int
    {
        return $this->score->total();
    }

    public function pointsByTour(): array
    {
        return $this->score->pointsByTour();
    }
}