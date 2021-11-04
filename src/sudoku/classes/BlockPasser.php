<?php

namespace Toolbox\Sudoku\Classes;

use Toolbox\Sudoku\Interfaces\BlockInterface;
use Toolbox\Sudoku\Interfaces\NumberPasserInterface;

class BlockPasser{
    public function __construct(
        protected array $blockArray = []
    ){
    }

    public function passBlock(){
        $passBlockArrayKey = array_rand($this->blockArray);
        $passBlockArrayValue = $this->blockArray[$passBlockArrayKey];
        $this->removeBlock($passBlockArrayKey);
        return $passBlockArrayValue;
    }

    public function removeBlock(int $passBlockArrayKey) :void{
        unset($this->blockArray[$passBlockArrayKey]);
    }
}