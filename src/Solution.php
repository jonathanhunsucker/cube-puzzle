<?php

class Solution
{
    const TURN_UP = "up";
    const TURN_RIGHT = "right";
    const TURN_DOWN = "down";
    const TURN_LEFT = "left";
    const TURN_FORWARD = "forward";
    const TURN_BACKWARD = "backward";

    const TURNS = [self::TURN_UP, self::TURN_RIGHT, self::TURN_DOWN, self::TURN_LEFT, self::TURN_FORWARD, self::TURN_BACKWARD];

    public function __construct(Puzzle $puzzle, array $turns)
    {
        $this->puzzle = $puzzle;
        $this->turns = $turns;
    }

    public function isValid()
    {
        $cube = new Cube($this->puzzle->width(), [[0, 0, 0]]);

        $pairs = self::pairwise($this->turns, $this->puzzle->lengths());
        foreach ($pairs as list($turn, $length)) {
            $cube = $cube->with($turn, $length);
            if ($cube->isValid() === false) {
                return false;
            }
        }

        return true;
    }

    private static function pairwise($as, $bs)
    {
        $length = min(count($as), count($bs));
        if ($length === 0) {
            return [];
        }

        $paired = [];
        $range = range(0, $length - 1);

        foreach ($range as $index) {
            $paired[] = [$as[$index], $bs[$index]];
        }

        return $paired;
    }

    public function isComplete()
    {
        return count($this->turns) === count($this->puzzle->lengths());
    }

    public function solvesIt()
    {
        return $this->isValid() && $this->isComplete();
    }

    public function potentialNextSolutions()
    {
        return array_map(function (string $turn) {
            return new Solution($this->puzzle, array_merge($this->turns, [$turn]));
        }, self::TURNS);
    }

    public function __toString()
    {
        return "Solution(" . implode(", ", $this->turns) . ")";
    }
}
