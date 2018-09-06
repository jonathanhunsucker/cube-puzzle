<?php

class Puzzle
{
    private $width;
    private $lengths;

    public function __construct($lengths)
    {
        $cube_root = pow(array_sum($lengths) - (count($lengths) - 1), 1/3);
        if (self::isIntegerValuedFloat($cube_root) === false) {
            throw new InvalidArgumentException("Provided $cube_root lengths cannot form a cube");
        }

        $this->width = $cube_root;
        $this->lengths = $lengths;
    }

    public function width()
    {
        return $this->width;
    }

    public function lengths()
    {
        return array_values($this->lengths);
    }

    private static function isIntegerValuedFloat(float $x)
    {
        return $x === round($x);
    }
}
