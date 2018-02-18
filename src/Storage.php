<?php
declare(strict_types=1);

namespace F3\MzgbServer;

interface Storage
{
    public function getGame($game_id): ?Game;
}