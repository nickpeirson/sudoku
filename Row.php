<?php
class Row extends Set
{

    protected function attachSetToCell(Cell $cell): void
    {
        $cell->setRow($this);
    }
}