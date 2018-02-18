<?php
declare(strict_types=1);

namespace F3\MzgbServer\Application;

use F3\MzgbServer\Game\TeamScore;

class ScoreBoardRowToArrayMapper
{
    public function __invoke(TeamScore $score): array
    {
        return [
            'team' => $score->toTeamName(),
            'rank' => $score->toRank(),
            'score' => $score->total(),
            'tours' => array_values($score->pointsByTour())
        ];
    }
}