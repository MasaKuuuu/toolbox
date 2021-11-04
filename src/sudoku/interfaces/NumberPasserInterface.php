<?php

namespace Toolbox\Sudoku\Interfaces;

interface NumberPasserInterface{
    public function passNumber() :int;
    public function removeNumber(int $passNumberArrayKey) :void;
}