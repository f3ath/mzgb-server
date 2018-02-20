<?php
declare(strict_types=1);

namespace F3\Mzgb\Application\ScoreBoard;

class Board
{
    private $rows = [];

    public function __construct(Row ...$rows)
    {
        $this->rows = $rows;
    }

    public function countRowsHigherThan(Row $row)
    {
        return count(array_filter($this->rows, new HigherThan($row)));
    }

    /**
     * @return Row[]
     */
    public function rowsSortedByRank(): array
    {
        $rows = $this->rows;
        usort($rows, new CompareByRank($this));
        return $rows;
    }
}