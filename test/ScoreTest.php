<?php
declare(strict_types=1);

namespace F3\Mzgb\Test;

use F3\Mzgb\Game\Score;
use F3\Mzgb\Game\Tour;
use F3\Mzgb\Game\TourResult;
use PHPUnit\Framework\TestCase;

class ScoreTest extends TestCase
{
    public function testScoreIsNotHigherThanItself()
    {
        $score = new Score(
            new TourResult(new Tour(1), 0, 0, 0, 1, 1, 1, 1)
        );
        $this->assertFalse($score->isHigherThan($score));
    }

    public function testScoreIsHigherIfHasMoreTotalPoints()
    {
        $alice = new Score(
            new TourResult(new Tour(1), 0, 0, 0, 1, 1, 1, 1)
        );
        $bob = new Score(
            new TourResult(new Tour(1), 1, 1, 1, 1, 1, 1, 1)
        );
        $this->assertEquals(4, $alice->total());
        $this->assertEquals(7, $bob->total());
        $this->assertTrue($bob->isHigherThan($alice));
        $this->assertFalse($alice->isHigherThan($bob));
    }

    public function testScoreIsHigherIfAcquiredMorePointsInLatestTour()
    {
        $alice = new Score(
            new TourResult(new Tour(1), 1, 1, 1, 1, 1, 1, 1),
            new TourResult(new Tour(2), 0, 0, 0, 1, 1, 1, 1)
        );
        $bob = new Score(
            new TourResult(new Tour(1), 0, 0, 0, 1, 1, 1, 1),
            new TourResult(new Tour(2), 1, 1, 1, 1, 1, 1, 1) // more point in 2nd tour
        );
        $this->assertTrue(($alice->total() === $bob->total()));
        $this->assertTrue($bob->isHigherThan($alice));
        $this->assertFalse($alice->isHigherThan($bob));
    }

}
