<?php
declare(strict_types=1);

namespace F3\Mzgb\Test;

use F3\Mzgb\Game\Tour;
use PHPUnit\Framework\TestCase;

class TourTest extends TestCase
{
    /**
     * @expectedException \OutOfBoundsException
     */
    public function testInvalidTourNumber()
    {
        new Tour(42);
    }

}
