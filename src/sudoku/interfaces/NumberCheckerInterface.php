<?php

namespace Toolbox\Sudoku\Interfaces;

use Toolbox\Sudoku\Interfaces\BlockInterface;

interface NumberCheckerInterface
{
    public function duplicateNumber(array $numberArray) :int|false;
    public function necessaryNumber(array $numberArray) :int|false;
}