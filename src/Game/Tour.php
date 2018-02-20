<?php
declare(strict_types=1);

namespace F3\Mzgb\Game;

class Tour
{
    const MAX_NUMBER = 7;
    const MIN_NUMBER = 1;

    private $number;

    public function __construct(int $number)
    {
        if (! self::isValid($number)) {
            throw new \OutOfBoundsException();
        }
        $this->number = $number;
    }

    public static function isValid(int $number):bool
    {
        return in_array($number, range(self::MIN_NUMBER, self::MAX_NUMBER), true);
    }

    public function isBlitz(): bool
    {
        return $this->number === 7;
    }

    public function isPointValid(int $p): bool
    {
        return $p === 0
            || $p === 1
            || ($this->isBlitz() && ($p === -2 || $p === 2));
    }

    public function number(): int
    {
        return $this->number;
    }
}