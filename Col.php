<?php

class Col extends Set
{

    protected function attachSetToCell(Cell $cell): void
    {
        $cell->setCol($this);
    }
}