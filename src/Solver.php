<?php

class Solver
{
    public function __construct(Puzzle $puzzle)
    {
        $this->puzzle = $puzzle;
    }

    public function solve()
    {
        $empty_solution = new Solution($this->puzzle, []);
        $solutions = $this->searchFrom($empty_solution);
        return $solutions;
    }

    private function searchFrom(Solution $solution)
    {
        if ($solution->isValid() === false) {
            return [];
        }

        if ($solution->isComplete()) {
            return [$solution];
        }

        return call_user_func_array('array_merge', array_values(array_map(function (Solution $next) {
            return $this->searchFrom($next);
        }, $solution->potentialNextSolutions())));
    }

    public function test()
    {
        $solution = new Solution($this->puzzle, [
            Solution::TURN_BACKWARD,
            Solution::TURN_RIGHT,
            Solution::TURN_FORWARD,
            Solution::TURN_UP,
            Solution::TURN_BACKWARD,
            Solution::TURN_LEFT,
            Solution::TURN_FORWARD,
        ]);

        var_dump($solution->isValid());
        var_dump($solution->isComplete());
    }
}
