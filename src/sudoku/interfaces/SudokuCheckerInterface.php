<?php

namespace Toolbox\Sudoku\Interfaces;

use Toolbox\Sudoku\Classes\Sudoku;

interface SudokuCheckerInterface
{
    public function checkSudokuRow();
    public function checkSudokuColumn();
    // public function searchNumberPlace(BlockInterface $block, int $serchNumber);
    // public function exchangeNumber(BlockInterface $block, int $columnNumber, int $rowNumber);
}