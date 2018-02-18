<?php
declare(strict_types=1);

namespace F3\Mzgb\Application;

use F3\Mzgb\Game\Score\Score;

class ScoreBoardRowToArrayMapper
{
    public function __invoke(Score $score): array
    {
        return [
            'team' => $score->toTeamName(),
            'rank' => $score->toRank(),
            'score' => $score->toPointsTotal(),
            'tours' => array_values($score->pointsByTour())
        ];
    }
}