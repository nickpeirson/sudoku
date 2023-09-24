<?php
class GridFactory
{
    protected array $cellValues;
    protected int $gridSize;
    protected NumberValidator $numberValidator;

    public function __construct(?int ...$cellValues) {
        $this->setGridSize($cellValues);
        $this->numberValidator = new NumberValidator($this->gridSize);
        $this->cellValues = $cellValues;
    }

    public function newGrid() : Grid {
        $rowsValues = [];
        $colsValues = [];
        $squaresValues = [];
        $cells = [];
        for ($index = 0; $index <= (($this->gridSize**2) - 1); $index++) {
            $cell = $this->buildCell($index);
            $cells[] = $cell;

            $indexes = new Indexes($index, $this->gridSize);

            $rowsValues = $this->buildRow($rowsValues, $indexes, $cell);
            $colsValues = $this->buildColumn($colsValues, $indexes, $cell);
            $squaresValues = $this->buildSquare($squaresValues, $indexes, $cell);
        }

        $rows = $this->buildRows($rowsValues);
        $cols = $this->buildCols($colsValues);
        $squares = $this->buildSquares($squaresValues);

        return new Grid(
            $rows,
            $cols,
            $squares,
            $cells
        );
    }

    protected function buildRows(array $setsValues): array
    {
        return $this->buildSets($setsValues, 'Row');
    }

    protected function buildCols(array $setsValues): array
    {
        return $this->buildSets($setsValues, 'Col');
    }

    protected function buildSquares(array $setsValues): array
    {
        return $this->buildSets($setsValues, 'Square');
    }

    protected function buildSets(array $setsValues, string $setType) : array {
        $sets = [];
        foreach ($setsValues as $setValues) {
            $sets[] = new $setType($setValues, $this->gridSize);
        }
        return $sets;
    }

    /**
     * @param int $index
     * @return Cell
     */
    private function buildCell(int $index): Cell
    {
        $cellValue = null;
        if (isset($this->cellValues[$index])) $cellValue = $this->cellValues[$index];
        return new Cell($cellValue, $this->numberValidator);
    }

    /**
     * @param array $rowsValues
     * @param Indexes $indexes
     * @param Cell $cell
     * @return array
     */
    private function buildRow(array $rowsValues, Indexes $indexes, Cell $cell): array
    {
        if (!isset($rowsValues[$indexes->getRowIndex()])) $rowsValues[$indexes->getRowIndex()] = [];
        $rowsValues[$indexes->getRowIndex()][$indexes->getColIndex()] = $cell;
        $cell->setIndexes($indexes);
        return $rowsValues;
    }

    /**
     * @param array $colsValues
     * @param Indexes $indexes
     * @param Cell $cell
     * @return array
     */
    private function buildColumn(array $colsValues, Indexes $indexes, Cell $cell): array
    {
        if (!isset($colsValues[$indexes->getColIndex()])) $colsValues[$indexes->getColIndex()] = [];
        $colsValues[$indexes->getColIndex()][$indexes->getRowIndex()] = $cell;
        return $colsValues;
    }

    /**
     * @param array $squaresValues
     * @param Indexes $indexes
     * @param Cell $cell
     * @return array
     */
    private function buildSquare(array $squaresValues, Indexes $indexes, Cell $cell): array
    {
        if (!isset($squaresValues[$indexes->getSquareIndex()])) $squaresValues[$indexes->getSquareIndex()] = [];
        $squaresValues[$indexes->getSquareIndex()][] = $cell;
        return $squaresValues;
    }

    /**
     * @param array $cellValues
     * @return void
     * @throws Exception
     */
    private function setGridSize(array $cellValues): void
    {
        $cellCount = count($cellValues);
        $gridSize = sqrt($cellCount);
        if ($gridSize != floor($gridSize)) throw new Exception('Grid must be square and have all values');
        $this->gridSize = $gridSize;
    }
}