<?php
declare(strict_types=1);

namespace F3\MzgbServer\Game;

class IsHigherThan
{
    private $score;

    public function __construct(TeamScore $score)
    {
        $this->score = $score;
    }

    public function __invoke(TeamScore $score): bool
    {
        return $score->isHigherThan($this->score);
    }
}