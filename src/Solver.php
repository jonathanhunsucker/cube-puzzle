<?php

class Solver
{
    public function __construct()
    {
        $this->puzzle = new Puzzle([3, 2, 2, 3, 2, 3, 2, 2, 3, 3, 2, 2, 2, 3, 3, 3, 3]);
        $this->puzzle = new Puzzle([3, 3, 3, 2, 2, 2, 2, 2, 3, 3, 3, 2, 3, 3, 3, 2, 2]);
        $this->puzzle = new Puzzle([2, 2, 2, 2, 2, 2, 2]);
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

        if (count($solutions)) {
            foreach ($solutions as $solution) {
                $this->exclaimVictory($solution);
            }
        } else {
            $this->noteDefeat();
        }
    }

    private function exclaimVictory(Solution $solution)
    {
        echo "Found solution: " . $solution . "\n";
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
