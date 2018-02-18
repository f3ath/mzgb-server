<?php
declare(strict_types=1);

namespace F3\MzgbServer;


class Game
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var \DateTimeInterface
     */
    private $date;

    /**
     * @var TeamScore[]
     */
    private $scores = [];

    public function __construct(string $id, string $name, \DateTimeInterface $date)
    {
        $this->id = $id;
        $this->name = $name;
        $this->date = $date;
    }

    public function toId(): string
    {
        return $this->id;
    }

    public function register(Team $team): void
    {
        $this->scores[$team->toId()] = new TeamScore($team);
    }

    public function score(Team $team, int $tour, array $points): void
    {
        $this->scores[$team->toId()]->score($tour, $points);
    }

    public function rank(TeamScore $score): int
    {
        $filterHigher = function (TeamScore $item) use ($score) {
            return $item->isHigherThan($score);
        };
        return count(array_filter($this->scores, $filterHigher)) + 1;
    }

    public function toScoreBoard(): array
    {
        $game = $this;
        $makeBoardRow = function (TeamScore $score) use ($game) {
            return new ScoreBoardRow(
                $score->toTeamName(),
                $game->rank($score),
                array_values($score->pointsByTour())
            );
        };
        $rows = array_map($makeBoardRow, $this->scores);
        usort($rows, function (ScoreBoardRow $a, ScoreBoardRow $b) {
            return $a->toRank() <=> $b->toRank();
        });
        return $rows;
    }
}