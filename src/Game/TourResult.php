<?php
declare(strict_types=1);

namespace F3\Mzgb\Game;

class TourResult
{
    /**
     * @var int
     */
    private $tour;
    /**
     * @var array
     */
    private $points;

    public function __construct(Tour $tour, int $q1, int $q2, int $q3, int $q4, int $q5, int $q6, int $q7)
    {
        $points = [$q1, $q2, $q3, $q4, $q5, $q6, $q7];
        foreach ($points as $point) {
            if (!$tour->isPointValid($point)) {
                throw new \OutOfBoundsException();
            }
        }
        $this->tour = $tour;
        $this->points = $points;
    }

    public function tourNumber(): int
    {
        return $this->tour->number();
    }

    public function points(): array
    {
        return $this->points;
    }

    public function pointsTotal(): int
    {
        return array_sum($this->points);
    }
}
