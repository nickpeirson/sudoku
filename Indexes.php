<?php
class Indexes
{
    protected int $index;
    protected int $colIndex;
    protected int $rowIndex;
    protected int $squareIndex;

    public function __construct (int $index, int $gridSize)
    {
        $squareSize = sqrt($gridSize);
        $this->index = $index;
        $this->colIndex = $index % $gridSize;
        $this->rowIndex = floor($index / $gridSize);
        $this->squareIndex = floor($this->colIndex / $squareSize) +
            floor($this->rowIndex / $squareSize) * $squareSize;
    }

    public function __toString(){
        return 'X:'.($this->getColIndex()+1).
            ', Y:'.($this->getRowIndex()+1);
    }

    /**
     * @return int
     */
    public function getColIndex(): int
    {
        return $this->colIndex;
    }

    /**
     * @return int
     */
    public function getRowIndex(): int
    {
        return $this->rowIndex;
    }

    /**
     * @return int
     */
    public function getSquareIndex(): int
    {
        return $this->squareIndex;
    }
}