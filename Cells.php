<?php

class Cells
{
    private SplObjectStorage $allCells;
    private SplObjectStorage $solvedCells;
    private SplObjectStorage $unsolvedCells;

    public function __construct()
    {
        $this->allCells = new SplObjectStorage();
        $this->unsolvedCells = new SplObjectStorage();
        $this->solvedCells = new SplObjectStorage();
    }

    public function __toString() {
        $str = '';
        foreach ($this->allCells as $cell) {
            $str .= $cell.' ';
        }
        return $str;
    }

    public function updateCell(Cell $cell) {
        $this->allCells->attach($cell);
        if ($cell->isEmpty()) {
            $this->cellUnsolved($cell);
        } else {
            $this->cellSolved($cell);
        }
    }

    private function cellSolved(Cell $cell) {
        $this->solvedCells->attach($cell);
        $this->unsolvedCells->detach($cell);
    }

    private function cellUnsolved(Cell $cell) {
        $this->solvedCells->detach($cell);
        $this->unsolvedCells->attach($cell);
    }

    public function getUnsolvedCells(): SplObjectStorage
    {
        return $this->unsolvedCells;
    }
}