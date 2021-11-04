<?php

namespace Toolbox\Sudoku\Classes;

use Toolbox\Sudoku\Interfaces\SudokuCheckerInterface;
use Toolbox\Sudoku\Classes\NumberChecker;
use Toolbox\Sudoku\Classes\Sudoku;

class SudokuChecker extends NumberChecker implements SudokuCheckerInterface{
    protected array $sudokuNumberList = [1,2,3,4,5,6,7,8,9];
    public function __construct(
        protected Sudoku $sudoku
    ){
    }

    public function checkSudokuRow(){
        foreach($this->sudokuNumberList as $sudokuNumber){
            $rowNumberList = [];

            foreach($this->sudoku->getSudokuRow() as $sudokuRow){
                if($sudokuNumber === $sudokuRow['sudokuRowNumber']){
                    array_push($rowNumberList, $sudokuRow['number']);
                }
            }
            var_dump($rowNumberList);

            if($duplicateNumber = $this->duplicateNumber($rowNumberList)){
                echo $sudokuNumber . "行目で重複している値" . $duplicateNumber;
                echo "\n";
            }

            if($necessaryNumber = $this->necessaryNumber($rowNumberList)){
                echo $sudokuNumber . "行目で足りない値" . $necessaryNumber;
                echo "\n";
            }
        }
    }

    public function checkSudokuColumn(){

    }
}