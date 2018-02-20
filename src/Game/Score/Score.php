<?php
declare(strict_types=1);

namespace F3\Mzgb\Game\Score;

use F3\Mzgb\Game\Tour;

class Score
{
    private $points = [];

    public function __construct(TourResult ...$results)
    {
        foreach ($results as $result) {
            $this->points[$result->tourNumber()] = $result->pointsTotal();
        }
    }

    public function pointsByTour(): array
    {
        return $this->points;
    }

    public function total(): int
    {
        return array_sum($this->points);
    }

    public function isHigherThan(Score $that): bool
    {
        if ($this->total() > $that->total()) {
            return true;
        }
        if ($this->total() < $that->total()) {
            return false;
        }
        $tour = Tour::MAX_NUMBER;
        while (Tour::isValid($tour) && $this->pointsIn($tour) === $that->pointsIn($tour)) {
            $tour--;
        }
        return $this->pointsIn($tour) > $that->pointsIn($tour);
    }

    private function pointsIn(int $tour): int
    {
        return $this->points[$tour] ?? 0;
    }
}