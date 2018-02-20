<?php
declare(strict_types=1);

namespace F3\Mzgb\Game\Score;

use F3\Mzgb\Game\Tour;

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

    public function __construct(Tour $tour, int ...$points)
    {
        if (count($points) !== 7) {
            throw new \OutOfBoundsException();
        }
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
