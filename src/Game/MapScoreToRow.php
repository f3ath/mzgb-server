<?php
declare(strict_types=1);

namespace F3\MzgbServer\Game;

class MapScoreToRow
{
    private $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    public function __invoke(TeamScore $score): Row
    {
        return new Row(
            $score->toTeamName(),
            $this->game->rank($score),
            array_values($score->pointsByTour())
        );
    }


}