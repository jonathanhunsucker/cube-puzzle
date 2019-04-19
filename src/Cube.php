<?php

class Cube
{
    /**
     * @param int $width - Width of the goal cube
     * @param int[3][] $filled - List of three-dimensional positions which have been filled already
     */
    public function __construct(int $width, array $filled)
    {
        $this->width = $width;
        $this->filled = $filled;
    }

    /**
     * @return boolean True if this Cube is physically possible, ie. no overlapping filled positions
     */
    public function isValid()
    {
        $seen = [];

        foreach ($this->filled as $position) {
            // enforce 'overlaps' criteria
            if (self::hasSeen($seen, $position)) {
                return false;
            }

            // enforce 'overflow' criteria
            foreach ($position as $coordinate) {
                if ($coordinate >= $this->width || $coordinate < 0) {
                    return false;
                }
            }

            $seen[] = $position;
        }

        return true;
    }

    /**
     * Build another Cube instance, similar to this one, but with an additional segment pointing in $turn direction for length $length
     *
     * @param string $turn - Identifier for direction, see `Solution::TURN_*`
     * @param int $length - Quantity of cubes in segment
     */
    public function with(string $turn, int $length)
    {
        $opening_position = $this->filled[count($this->filled) - 1];
        $more_positions = $this->takeTurnFrom($opening_position, $turn, $length);
        return new Cube($this->width, array_merge($this->filled, $more_positions));
    }

    private function takeTurnFrom(array $position, string $turn, int $length)
    {
        $more_positions = [];
        foreach (range(1, $length - 1) as $distance) {
            $more_positions[] = $this->createPositionFrom($position, $turn, $distance);
        }
        return $more_positions;
    }

    private function createPositionFrom(array $position, string $turn, int $distance)
    {
        switch ($turn) {
            case Solution::TURN_UP:
                return [$position[0], $position[1] + $distance, $position[2]];
                break;
            case Solution::TURN_DOWN:
                return [$position[0], $position[1] - $distance, $position[2]];
                break;
            case Solution::TURN_RIGHT:
                return [$position[0] + $distance, $position[1], $position[2]];
                break;
            case Solution::TURN_LEFT:
                return [$position[0] - $distance, $position[1], $position[2]];
                break;
            case Solution::TURN_BACKWARD:
                return [$position[0], $position[1], $position[2] + $distance];
                break;
            case Solution::TURN_FORWARD:
                return [$position[0], $position[1], $position[2] - $distance];
                break;
        }
    }

    private static function hasSeen(array $seen, array $position)
    {
        foreach ($seen as $seen_position) {
            if (self::positionIsEqual($seen_position, $position)) {
                return true;
            }
        }

        return false;
    }

    private static function positionIsEqual($a, $b)
    {
        return $a[0] === $b[0] && $a[1] === $b[1] && $a[2] === $b[2];
    }
}
