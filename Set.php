<?php
abstract class Set {
    /**
     * @var CelL[]
     */
    protected Cells $cells;
    protected int $gridSize;

    //Move numbers onto a new solved/unsolved cells class
    protected array $validNumbers;
    protected array $usedNumbers = [];
    protected array $unusedNumbers = [];

    public function __construct(array $cells, int $gridSize) {
        $this->gridSize = $gridSize;
        $this->initialiseValidNumbers();
        $this->setCells($cells);
    }

    protected function initialiseValidNumbers() :void {
        $numbers = range(1, $this->gridSize);
        $this->validNumbers = array_combine($numbers, $numbers);
        $this->unusedNumbers = $this->validNumbers;
    }

    abstract protected function attachSetToCell(Cell $cell) : void;

    public function __toString() {
        return $this->cells;
    }

    /**
     * @param array $cells
     * @return void
     * @throws Exception
     */
    private function setCells(array $cells): void
    {
        if (count($cells) != $this->gridSize) throw new Exception('Must have exactly '.$this->gridSize.' cells');
        $this->cells = new Cells();

        foreach ($cells as $cell) {
            $this->attachSetToCell($cell);
            if (!$cell->isEmpty()) $this->useNumber($cell);
            $this->cells->updateCell($cell);
        }
    }

    public function useNumber(Cell $cell): void
    {
        $number = $cell->getNumber();
        if (!isset($this->validNumbers[$number])) throw new Exception('Number '.$number.' is not valid for this set');
        if (isset($this->usedNumbers[$number])) throw new Exception('Number '.$number.' was already used in this set');
        unset($this->unusedNumbers[$number]);
        $this->usedNumbers[$number] = $number;
        $this->cells->updateCell($cell);
    }

    /**
     * @return array
     */
    public function getUnusedNumbers(): array
    {
        return $this->unusedNumbers;
    }

    /**
     * @return void
     */
    public function setWhereOnlyOneCellIsValidForNumber(): void
    {
        $unusedNumbers = $this->unusedNumbers;
        foreach ($unusedNumbers as $number) {
            $validCell = null;
            foreach ($this->cells->getUnsolvedCells() as $cell) {
                if (!$this->isNumberValidForCell($cell, $number)) continue;
                if (!is_null($validCell)) {
                    $validCell = null;
                    break;
                }
                $validCell = $cell;
            }
            if ($validCell) {
                $validCell->setNumber($number);
            }
        }
    }

    /**
     * @param CelL $cell
     * @param mixed $number
     * @return bool
     */
    private function isNumberValidForCell(CelL $cell, mixed $number): bool
    {
        return isset($cell->getValidValues()[$number]);
    }
}