<?php
declare(strict_types=1);

namespace F3\MzgbServer\Application;

use F3\MzgbServer\ScoreBoardRow;

class ScoreBoardRowToArrayMapper
{
    public function __invoke(ScoreBoardRow $row): array
    {
        return [
            'team' => $row->toTeamName(),
            'rank' => $row->toRank(),
            'score' => $row->toTotalScore(),
            'tours' => $row->toScoreByTours()
        ];
    }
}