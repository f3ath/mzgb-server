<?php
declare(strict_types=1);

namespace F3\Mzgb\Application\ScoreBoard;

class HigherThan
{
    /**
     * @var Row
     */
    private $row;

    public function __construct(Row $row)
    {
        $this->row = $row;
    }

    public function __invoke(Row $row): bool
    {
        return $row->hasHigherScoreThan($this->row);
    }
}