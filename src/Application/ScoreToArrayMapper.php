<?php
declare(strict_types=1);

namespace F3\Mzgb\Application;

use F3\Mzgb\Game\Score;

class ScoreToArrayMapper
{
    public function __invoke(Score $score): array
    {
        return [
            'team' => $score->getTeamName(),
            'rank' => $score->rankInBoard(),
            'score' => $score->total(),
            'tours' => array_values($score->pointsByTour())
        ];
    }
}