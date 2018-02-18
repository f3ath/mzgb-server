<?php
declare(strict_types=1);

namespace F3\Mzgb\Game\Score;

class CompareByRank
{
    public function __invoke(Score $a, Score $b): int
    {
        return $a->toRank() <=> $b->toRank();
    }
}