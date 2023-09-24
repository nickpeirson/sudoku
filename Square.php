<?php

class Square extends Set
{
    protected function attachSetToCell(Cell $cell): void
    {
        $cell->setSquare($this);
    }
}