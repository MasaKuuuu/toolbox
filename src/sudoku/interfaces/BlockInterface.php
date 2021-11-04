<?php

namespace Toolbox\Sudoku\Interfaces;

use Toolbox\Sudoku\Interfaces\NumberPasserInterface;

interface BlockInterface
{
    public function setNumberCoordinate(NumberPasserInterface $numberPasser): void;
    public function getNumberCoordinate(): array;
    public function getRow(int $rowNumber): array;
    public function getColumn(int $columnNumber): array;
    public function searchNumberCoordinate(int $searchNumber): array;
    public function exchangeNumberCoordinate(int $beforeNumber, int $afterNumber): void;
}