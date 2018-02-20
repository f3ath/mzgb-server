<?php
declare(strict_types=1);

namespace F3\Mzgb\Application\ScoreBoard;

class CompareByRank
{
    /**
     * @var Board
     */
    private $board;

    public function __construct(Board $board)
    {
        $this->board = $board;
    }

    public function __invoke(Row $a, Row $b): int
    {
        return $a->rank($this->board) <=> $b->rank($this->board);
    }
}