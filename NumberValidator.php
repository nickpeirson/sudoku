<?php

class NumberValidator
{
    private int $gridSize;

    public function __construct(int $gridSize)
    {
        $this->gridSize = $gridSize;
    }

    public function __invoke(?int $value) :bool
    {
        if (is_null($value)) return true;
        if ($value >= 1 && $value <= $this->gridSize) return true;
        throw new Exception('Number out of range [1-'.$this->gridSize.']: ' . $value);
    }
}