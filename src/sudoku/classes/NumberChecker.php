<?php

namespace Toolbox\Sudoku\Classes;

use Toolbox\Sudoku\Interfaces\NumberCheckerInterface;

class NumberChecker implements NumberCheckerInterface{
    public function __construct(
        public array $checkNumberList = [1,2,3,4,5,6,7,8,9]
    ){
    }

    public function duplicateNumber(array $numberArray) :int|false{
        $checkedDuplicateNumbserArray = array_count_values($numberArray);
        foreach($checkedDuplicateNumbserArray as $number => $count){
            if($count > 1){
                return $number;
            }
        }
        return false;
    }

    public function necessaryNumber(array $numberArray) :int|false{
        foreach($this->checkNumberList as $checkNumber){
            if(!in_array($checkNumber, $numberArray)){
                return $checkNumber;
            }
        }
        return false;
    }
}