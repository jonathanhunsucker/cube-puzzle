<?php

class Bench
{
    public function test()
    {
        foreach ($this->getPuzzles() as $puzzle) {
            $solver = new Solver($puzzle);
            $solutions = $solver->solve();

            if (count($solutions)) {
                foreach ($solutions as $solution) {
                    $this->exclaimVictory($solution);
                }
            } else {
                $this->noteDefeat();
            }
        }
    }

    private function exclaimVictory(Solution $solution)
    {
        echo "Found solution: " . $solution . "\n";
    }

    private function noteDefeat()
    {
        echo "Failed to find solution\n";
    }

    private function getPuzzles()
    {
        return [
            new Puzzle([3, 2, 2, 3, 2, 3, 2, 2, 3, 3, 2, 2, 2, 3, 3, 3, 3]),
            new Puzzle([3, 3, 3, 2, 2, 2, 2, 2, 3, 3, 3, 2, 3, 3, 3, 2, 2]),
            new Puzzle([2, 2, 2, 2, 2, 2, 2]),
        ];
    }
}
