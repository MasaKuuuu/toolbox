<?php

namespace Toolbox\Sudoku\Classes;

use Toolbox\Sudoku\Classes\BlockPasser;

class Sudoku {
    protected array $rowBlockArray = [];
    protected array $columnBlockArray = [];
    protected array $sudokuRowArray = [];
    protected array $sudokuColumnArray = [];
    protected array $blockCoordinateArray = [];

    public function __construct(
        protected int $maxRowBlock = 3,
        protected int $maxColumnBlock = 3
    ){
    }

    public function setBlockCoodinate(BlockPasser $blockPasser) :void{
        for ($rowBlockNumber=1; $rowBlockNumber<=$this->maxRowBlock; $rowBlockNumber++){
            for ($columnBlockNumber=1; $columnBlockNumber<=$this->maxColumnBlock; $columnBlockNumber++){
                array_push($this->blockCoordinateArray,
                    [
                        "blockRow" => $rowBlockNumber,
                        "blockColumn" => $columnBlockNumber,
                        "block" => $blockPasser->passBlock()
                    ]
                );
            }
        }        
    }

    public function setRowBlock() :void{
        for ($rowBlockNumber=1; $rowBlockNumber<=$this->maxRowBlock; $rowBlockNumber++){
            $this->rowBlockArray[$rowBlockNumber] = [];
            for ($columnBlockNumber=1; $columnBlockNumber<=$this->maxColumnBlock; $columnBlockNumber++){
                // array_push($this->rowBlockArray[$rowBlockNumber], $blockPasser->passBlock());
            }
        }
    }

    public function setColumnBlock() :void{
        for ($columnBlockNumber=1; $columnBlockNumber<=$this->maxColumnBlock; $columnBlockNumber++){
            $this->columnBlockArray[$columnBlockNumber] = [];
            foreach($this->getRowBlock() as $rowBlockNumber => $rowBlockArray){
                foreach($rowBlockArray as $rowNumber => $block){
                    array_push($this->columnBlockArray[$columnBlockNumber], $block);
                }
            }
        }
    }

    public function getRowBlock() :array{
        return $this->rowBlockArray;
    }

    public function getColumnBlock() :array{
        return $this->columnBlockArray;
    }

    /**
     * 何行目のブロックの何行目という情報を持っている
     */
    public function setSudokuRow(){
        foreach($this->getRowBlock() as $rowBlockNumber => $rowBlockArray){
            foreach($rowBlockArray as $columnBlockNumber => $block){
                foreach($block->getRow() as $rowNumber => $rowArray){
                    foreach($rowArray as $columnNumber => $number){
                        array_push(
                            $this->sudokuRowArray,
                            [
                                "sudokuRowNumber" => (($rowBlockNumber - 1) * 3) + $rowNumber,
                                "rowBlockNumber" => $rowBlockNumber,
                                "rowNumber" => $rowNumber,
                                "number" => $number
                            ]
                        );
                    }
                }
            }
        }
    }

    public function setSudokuColumn(){
        foreach($this->getColumnBlock() as $columnBlockNumber => $columnBlockArray){
            foreach($columnBlockArray as $rowBlockNumber => $block){
                foreach($block->getColumn() as $columnNumber => $columnArray){
                    foreach($columnArray as $rowNumber => $number){
                        array_push(
                            $this->sudokuColumnArray,
                            [
                                "sudokuColumnNumber" => (($columnBlockNumber -1) * 3 ) + $columnNumber,
                                "columnBlockNumber" => $columnBlockNumber,
                                "columnNumber" => $columnNumber,
                                "number" => $number
                            ]
                        );
                    }
                }
            }
        }
    }

    public function getSudokuRow(int $blockRowNumber, int $rowNumber) :array{
        $sudokuRow = [];
        foreach($this->getBlockCoordinateArray() as $blockCoordinate){
            if($blockCoordinate["blockRow"] === $blockRowNumber){
                $sudokuRow = array_merge($sudokuRow,$blockCoordinate["block"]->getRow($rowNumber));
            }
        }
        return $sudokuRow;
    }

    public function getSudokuColumn(int $blockColumnNumber, int $columnNumber) :array{
        $sudokuColumn = [];
        foreach($this->getBlockCoordinateArray() as $blockCoordinate){
            if($blockCoordinate["blockColumn"] === $blockColumnNumber){
                $sudokuColumn = array_merge($sudokuColumn,$blockCoordinate["block"]->getColumn($columnNumber));
            }
        }
        return $sudokuColumn;
    }

    public function getBlockCoordinateArray() :array{
        return $this->blockCoordinateArray;
    }

    public function searchNumberCoordinate(string $searchType, int $sudokuNumber, int $blockNumber, int $searchNumber) :array{
        $numberCoordinate = [];
        switch($searchType){
            case "row":
                foreach($this->getBlockCoordinateArray() as $blockCoordinate){
                    if($blockCoordinate["blockRow"] === $sudokuNumber){
                        foreach($blockCoordinate["block"] as $blockArray){
                            foreach($blockArray as $block){
                                if($block["row"] === $blockNumber && $block["number"] === $searchNumber){
                                    array_push(
                                        $numberCoordinate,
                                        [
                                            "blockRow" => $blockCoordinate["blockRow"],
                                            "blockColumn" => $blockCoordinate["blockColumn"],
                                            "block" => $block
                                        ]
                                    );
                                }
                            }
                        }
                    }
                }
                break;
            case "column":
                foreach($this->getBlockCoordinateArray() as $blockCoordinate){
                    if($blockCoordinate["blockColumn"] === $sudokuNumber){
                        foreach($blockCoordinate["block"] as $blockArray){
                            foreach($blockArray as $block){
                                if($block["column"] === $blockNumber && $block["number"] === $searchNumber){
                                    array_push(
                                        $numberCoordinate,
                                        [
                                            "blockRow" => $blockCoordinate["blockRow"],
                                            "blockColumn" => $blockCoordinate["blockColumn"],
                                            "block" => $block
                                        ]
                                    );
                                }
                            }
                        }
                    }
                }
                break;
            default:
                break;
        }
        return $numberCoordinate;
    }

    public function exchangeNumberCoordinate(int $blockRow, int $blockColumn, int $beforeNumber, int $afterNumber) :void{
        foreach($this->getBlockCoordinateArray() as $blockCoordinate){
            if($blockCoordinate["blockRow"] === $blockRow && $blockCoordinate["blockColumn"] === $blockColumn){
                $blockCoordinate["block"]->exchangeNumberCoordinate($beforeNumber, $afterNumber);
            }
        }
    }
}