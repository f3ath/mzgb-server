<?php
declare(strict_types=1);

namespace F3\MzgbServer\Game;

class CompareRowsByRank
{
    public function __invoke(Row $a, Row $b): int
    {
        return $a->toRank() <=> $b->toRank();
    }
}