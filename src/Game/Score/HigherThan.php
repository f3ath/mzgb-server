<?php
declare(strict_types=1);

namespace F3\MzgbServer\Game\Score;

class HigherThan
{
    private $score;

    public function __construct(Score $score)
    {
        $this->score = $score;
    }

    public function __invoke(Score $score): bool
    {
        return $score->isHigherThan($this->score);
    }
}