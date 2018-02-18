<?php
declare(strict_types=1);

namespace F3\MzgbServer;


class ScoreBoardRow
{
    /**
     * @var string
     */
    private $team_name;
    /**
     * @var int
     */
    private $rank;
    /**
     * @var array
     */
    private $scores;

    /**
     * @param string $team_name
     * @param int $rank
     * @param int[] $scores
     */
    public function __construct(string $team_name, int $rank, array $scores)
    {
        $this->team_name = $team_name;
        $this->rank = $rank;
        $this->scores = $scores;
    }

    public function toTeamName(): string
    {
        return $this->team_name;
    }

    public function toRank(): int
    {
        return $this->rank;
    }

    public function toTotalScore(): int
    {
        return array_sum($this->scores);
    }

    /**
     * @return int[]
     */
    public function toScoreByTours(): array
    {
        return $this->scores;
    }
}