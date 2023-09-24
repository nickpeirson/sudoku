<?php
class Cell {
    protected ?int $number = null;
    protected ?Set $row = null;
    protected ?Set $col = null;
    protected ?Set $square = null;
    protected ?Indexes $indexes = null;
    private NumberValidator $validator;

    public function __construct(?int $number, NumberValidator $validator)
    {
        $this->validator = $validator;
        $this->setNumber($number);
    }

    public function solve() :void {
        if (!$this->isEmpty()) {
            return;
        }
        $this->isOnlyOneNumberValid();
    }

    /**
     * @return void
     * @throws Exception
     */
    private function isOnlyOneNumberValid(): void
    {
        $validValues = $this->getValidValues();
        if (count($validValues) != 1) {
            return;
        }
        $this->setNumber(array_values($validValues)[0]);
    }

    public function getValidValues(): array
    {
        $unusedNumbersArrays = array_map(function (Set $set) {
            return $set->getUnusedNumbers();
        }, $this->getSets());
        return array_intersect_key(...$unusedNumbersArrays);
    }

    /**
     * @return Set[]
     */
    private function getSets(): array
    {
        return [
            $this->row,
            $this->col,
            $this->square
        ];
    }

    public function getNumber() : ?int {
        return $this->number;
    }

    /**
     * @param int $number
     */
    public function setNumber(?int $number): void
    {
        ($this->validator)($number);
        echo "Setting ".$this->indexes." to ".$number."\n";
        $this->number = $number;
        foreach($this->getSets() as $set) {
            if (!$set instanceof Set) {
                continue;
            }
            $set->useNumber($this);
        }
    }

    public function isEmpty() : bool {
        return is_null($this->number);
    }

    public function __toString(): string
    {
        if ($this->isEmpty()) {
            return ' ';
        }
        return (string) $this->number;
    }

   /**
     * @param Set $row
     */
    public function setRow(Set $row): void
    {
        $this->row = $row;
    }

    /**
     * @param Set $col
     */
    public function setCol(Set $col): void
    {
        $this->col = $col;
    }

   /**
     * @param Set $square
     */
    public function setSquare(Set $square): void
    {
        $this->square = $square;
    }

    /**
     * @param Indexes|null $indexes
     */
    public function setIndexes(?Indexes $indexes): void
    {
        $this->indexes = $indexes;
    }
}