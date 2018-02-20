<?php
declare(strict_types=1);

namespace F3\Mzgb\Application;

use F3\Mzgb\Game\Game;
use F3\Mzgb\Game\Team;

class Registration
{
    /**
     * @var Game
     */
    private $game;
    /**
     * @var Team
     */
    private $team;
    /**
     * @var \DateTimeInterface
     */
    private $created;

    public function __construct(Game $game, Team $team, \DateTimeInterface $created)
    {
        $this->game = $game;
        $this->team = $team;
        $this->created = $created;
    }

    public function toGameId(): string
    {
        return $this->game->getId();
    }

    public function toTeamId(): string
    {
        return $this->team->getId();
    }

    public function toCreationTime(): \DateTimeInterface
    {
        return $this->created;
    }
}