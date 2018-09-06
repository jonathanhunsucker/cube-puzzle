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

        $queue = new FifoQueue();
        $queue->push($empty_solution);

        $solutions = [];
        while ($queue->hasItems()) {
            $solution = $queue->pop();
            if ($solution->isValid()) {
                if ($solution->isComplete()) {
                    $solutions[] = $solution;
                } else {
                    $queue->pushAll($solution->potentialNextSolutions());
                }
            }
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
