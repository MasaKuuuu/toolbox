<?php

namespace Toolbox\Sudoku\Classes;

use Toolbox\Sudoku\Interfaces\NumberPasserInterface;

class NumberPasser implements NumberPasserInterface{
    private array $numberArray = [];

    public function __construct(
        protected int $number = 3
    ){
        for($i=1; $i<=($this->number*$this->number); $i++){
            array_push($this->numberArray, $i);
        }
    }

    /**
     * 値を返す
     * また、返した値は配列から削除する
     * @return int $passNumbserArrayValue 値
     */
    public function passNumber() :int{
        $passNumberArrayKey = array_rand($this->numberArray);
        $passNumberArrayValue = $this->numberArray[$passNumberArrayKey];
        $this->removeNumber($passNumberArrayKey);
        return $passNumberArrayValue;
    }

    /**
     * 配列を取り除く
     * 
     * @var int $passSumbserArrayKey 取り除く値のKey
     */
    public function removeNumber(int $passNumberArrayKey) :void{
        unset($this->numberArray[$passNumberArrayKey]);
    }

}