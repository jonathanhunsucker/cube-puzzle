<?php

class Solver
{
    public function __construct(Puzzle $puzzle)
    {
        $this->puzzle = $puzzle;
        $this->solutions = [new Solution($this->puzzle, [])];
    }

    public function solve()
    {
        $solutions = [];
        foreach ($this->getPotentialSolution() as $solution) {
            if ($solution->isValid()) {
                if ($solution->isComplete()) {
                    $solutions[] = $solution;
                } else {
                    $this->pushMoreSolutions($solution->potentialNextSolutions());
                }
            }
        }

        return $solutions;
    }

    private function getPotentialSolution()
    {
        while (count($this->solutions) > 0) {
            yield array_shift($this->solutions);
        }
    }

    private function pushMoreSolutions(array $solutions)
    {
        foreach ($solutions as $solution) {
            array_push($this->solutions, $solution);
        }
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
