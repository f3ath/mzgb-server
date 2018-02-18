<?php
declare(strict_types=1);

namespace F3\MzgbServer\Game;

class CompareByRank
{
    public function __invoke(TeamScore $a, TeamScore $b): int
    {
        return $a->toRank() <=> $b->toRank();
    }
}