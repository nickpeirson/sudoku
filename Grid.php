<?php
class Grid
{
    /** @var Row[]  */
    protected array $rows = [];
    /** @var Col[]  */
    protected array $cols = [];
    /** @var Square[] */
    protected array $squares = [];
    /** @var Cell[] */
    protected array $cells;

    protected int $emptyCells = 0;

    public function __construct(
        array $rows,
        array $cols,
        array $squares,
        array $cells
    ) {
        $this->rows = $rows;
        $this->cols = $cols;
        $this->squares = $squares;
        $this->cells = $cells;
        foreach ($this->cells as $cell) {
            if ($cell->isEmpty()) $this->emptyCells++;
        }
    }

    public function solve() :void {
        while($this->emptyCells > 0) {
            $this->solveOnce();
        }
    }

    public function solveOnce() :void {
        echo "Empty cells: ".$this->emptyCells."\n";
        foreach ($this->getSets() as $set) {
            $set->setWhereOnlyOneCellIsValidForNumber();
        }
        $this->findCellsWithOnlyOneValidNumber();
        echo $this->dumpRows();
    }

    /**
     * @return void
     */
    private function findCellsWithOnlyOneValidNumber(): void
    {
        $emptyCells = 0;
        foreach ($this->cells as $cell) {
            $cell->solve();
            if ($cell->isEmpty()) $emptyCells++;
        }
        $this->emptyCells = $emptyCells;
    }

    public function dump() : string {
        return $this->dumpRows().
            'Cols:'."\n".
            implode("\n", $this->cols)."\n"."\n".
            'Squares:'."\n".
            implode("\n", $this->squares);
    }

    public function dumpRows() :string {
        return 'Rows:'."\n".
            implode("\n", $this->rows)."\n"."\n";
    }

    /**
     * @return array|Col[]|Row[]|Square[]
     */
    private function getSets(): array
    {
        return array_merge(
            $this->rows,
            $this->cols,
            $this->squares
        );
    }
}