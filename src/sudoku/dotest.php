<?php

use phpDocumentor\Reflection\Types\Boolean;
use Toolbox\Sudoku\Classes\NumberPasser;
use Toolbox\Sudoku\Classes\Block;
use Toolbox\Sudoku\Classes\BlockPasser;
use Toolbox\Sudoku\Classes\Sudoku;
use Toolbox\Sudoku\Classes\NumberChecker;
use Toolbox\Sudoku\Classes\SudokuChecker;

require_once __DIR__ . "/../../vendor/autoload.php";

$blockArray = [];

for($i = 0; $i<4; $i++){
    $block = new Block(2, 2);
    $numberPasser = new NumberPasser(2);
    $block->setNumberCoordinate($numberPasser);
    array_push($blockArray, $block);
}

$blockPasser = new BlockPasser($blockArray);

$sudoku = new Sudoku(2, 2);
$sudoku->setBlockCoodinate($blockPasser);

$numberChecker = new NumberChecker([1,2,3,4]);

while(true){
    $exchangeRowFlag = false;
    $exchangeColumnFlag = false;

    // 行のチェック
    foreach($sudoku->getBlockCoordinateArray() as $blockCoordinate){
        for($blockRow = 1;$blockRow <= 2;$blockRow++){
            for($row = 1;$row <= 2;$row++){
                $duplicateNumber = $numberChecker->duplicateNumber($sudoku->getSudokuRow($blockRow, $row));
                $necessaryNumber = $numberChecker->necessaryNumber($sudoku->getSudokuRow($blockRow, $row));

                if($duplicateNumber && $necessaryNumber){
                    // ブロックが複数返されるが最初に見つかったブロックだけ交換してリトライさせる
                    foreach($sudoku->searchNumberCoordinate("row", $blockRow, $row, $duplicateNumber) as $searchNumberCoordinate){
                        $sudoku->exchangeNumberCoordinate($blockRow, $searchNumberCoordinate["blockColumn"], $duplicateNumber, $necessaryNumber);
                        $blockRow = 1;
                        $row = 1;
                        break;
                    }
                }
            }
        }
    }
    $exchangeRowFlag = true;

    // 列のチェック
    foreach($sudoku->getBlockCoordinateArray() as $blockCoordinate){
        for($blockColumn = 1;$blockColumn <= 2;$blockColumn++){
            for($column = 1;$column <= 2;$column++){
                $duplicateNumber = $numberChecker->duplicateNumber($sudoku->getSudokuColumn($blockColumn, $column));
                $necessaryNumber = $numberChecker->necessaryNumber($sudoku->getSudokuColumn($blockColumn, $column));

                if($duplicateNumber && $necessaryNumber){
                    // ブロックが複数返されるが最初に見つかったブロックだけ交換してリトライさせる
                    foreach($sudoku->searchNumberCoordinate("column", $blockColumn, $column, $duplicateNumber) as $searchNumberCoordinate){
                        $sudoku->exchangeNumberCoordinate($blockColumn, $searchNumberCoordinate["blockColumn"], $duplicateNumber, $necessaryNumber);
                        $blockColumn = 1;
                        $column = 1;
                        $exchangeRowFlag = false;
                        break;
                    }
                }
            }
        }
    }
    $exchangeColumnFlag = true;

    if($exchangeRowFlag && $exchangeColumnFlag){
        break;
    }
}

echo("交換完了");
var_dump($sudoku->getBlockCoordinateArray());

// $sudokuChecker = new SudokuChecker($sudoku);
// $sudokuChecker->checkSudokuRow();