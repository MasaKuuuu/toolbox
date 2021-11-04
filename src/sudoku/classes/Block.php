<?php

namespace Toolbox\Sudoku\Classes;

use Toolbox\Sudoku\Interfaces\BlockInterface;
use Toolbox\Sudoku\Interfaces\NumberPasserInterface;

class Block implements BlockInterface{
    public array $numberCoordinateArray = [];

    public function __construct(
        protected int $maxRowNumber = 3,
        protected int $maxColumnNumber = 3
    ){
    }

    public function setNumberCoordinate(NumberPasserInterface $numberPasser) :void{
        for ($rowNumber=1; $rowNumber<=$this->maxRowNumber; $rowNumber++){
            for ($columnNumber=1; $columnNumber<=$this->maxColumnNumber; $columnNumber++){
                array_push($this->numberCoordinateArray,
                    [
                        "row" => $rowNumber,
                        "column" => $columnNumber,
                        "number" => $numberPasser->passNumber()
                    ]
                );
            }
        }        
    }

    public function getNumberCoordinate() :array{
        return $this->numberCoordinateArray;
    }

    public function getRow(int $rowNumber) :array{
        $row = [];
        foreach($this->getNumberCoordinate() as $numberCoordinate){
            if($numberCoordinate["row"] === $rowNumber){
                array_push($row,$numberCoordinate["number"]);
            }
        }
        return $row;
    }

    public function getColumn(int $columnNumber) :array{
        $column = [];
        foreach($this->getNumberCoordinate() as $numberCoordinate){
            if($numberCoordinate["column"] === $columnNumber){
                array_push($column, $numberCoordinate["number"]);
            }
        }
        return $column;
    }

    public function searchNumberCoordinate(int $searchNumber) :array{
        foreach($this->getNumberCoordinate() as $numberCoordinate){
            if($searchNumber === $numberCoordinate["number"]){
                return $numberCoordinate;
            }
        }
    }

    public function exchangeNumberCoordinate(int $beforeNumber, int $afterNumber) :void{
        $beforeNumberCoordinate = $this->searchNumberCoordinate($beforeNumber);
        $afterNumberCoordinate = $this->searchNumberCoordinate($afterNumber);

        // 先に入れ替える
        foreach($this->numberCoordinateArray as $key => $numberCoordinate){
            if($numberCoordinate["row"] === $beforeNumberCoordinate["row"]){
                if($numberCoordinate["column"] === $beforeNumberCoordinate["column"]){
                    unset($this->numberCoordinateArray[$key]);
                    array_push($this->numberCoordinateArray,
                        [
                            "row" => $beforeNumberCoordinate["row"],
                            "column" => $beforeNumberCoordinate["column"],
                            "number" => $afterNumber
                        ]
                    );
                }
            }
        }

        // 後で値を入れなおす
        foreach($this->numberCoordinateArray as $key => $numberCoordinate){
            if($numberCoordinate["row"] === $afterNumberCoordinate["row"]){
                if($numberCoordinate["column"] === $afterNumberCoordinate["column"]){
                    unset($this->numberCoordinateArray[$key]);
                    array_push($this->numberCoordinateArray,
                        [
                            "row" => $afterNumberCoordinate["row"],
                            "column" => $afterNumberCoordinate["column"],
                            "number" => $beforeNumber
                        ]
                    );
                }
            }
        }
    }
}