<?php

abstract class Piece
{

    protected $color = "white";
    public $position;
    const CELLS = [
        "a" => ["1","2","3","4","5","6","7","8",],
        "b" => ["1","2","3","4","5","6","7","8",],
        "c" => ["1","2","3","4","5","6","7","8",],
        "d" => ["1","2","3","4","5","6","7","8",],
        "e" => ["1","2","3","4","5","6","7","8",],
        "f" => ["1","2","3","4","5","6","7","8",],
        "g" => ["1","2","3","4","5","6","7","8",],
        "h" => ["1","2","3","4","5","6","7","8",],
    ];    

    public function __construct ($opts = []) {

        if (isset($opts["color"]) && (in_array($opts["color"], ["black", "white"]))) {
            $this->color = $opts["color"];
        }

        $this->position = $opts["position"];

    }

    abstract public function getName();

    // public function setColor($color)
    // {
    //     $this->color = $color;
    // }

    // public function getColor()
    // {
    //     return $this->color;
    // }

    public function getPosition()
    {
        return $this->position;
    }

}

class King extends Piece
{

    private $name = "king";

    public function getName()
    {
        return $this->name;
    }

}

class Rook extends Piece
{

    private $name = "rook";

    public function getName()
    {
        return $this->name;
    }

    public function getAccesibleCells ($opts = []) {

        $position = $this->position;
        $rookVertical = $position["vertical"];
        $rookHorizontal = $position["horizontal"];
        $accessibleCells = [];

        foreach (self::CELLS[$rookVertical] as $curVertCellNum) {
            if ($curVertCellNum != $rookHorizontal) {
                $curCell = "{$rookVertical}{$curVertCellNum}";
                $accessibleCells[] = $curCell;
            }
        }
        foreach (array_keys(self::CELLS) as $curHorCellName) {
            if ($curHorCellName != $rookVertical) {
                $curCell = "{$curHorCellName}{$rookHorizontal}";
                $accessibleCells[] = $curCell;
            }
        }

        return $accessibleCells;

    }    

}


// class ChessBoard
// {

//     const CELLS = [
//         "a" => ["1","2","3","4","5","6","7","8",],
//         "b" => ["1","2","3","4","5","6","7","8",],
//         "c" => ["1","2","3","4","5","6","7","8",],
//         "d" => ["1","2","3","4","5","6","7","8",],
//         "e" => ["1","2","3","4","5","6","7","8",],
//         "f" => ["1","2","3","4","5","6","7","8",],
//         "g" => ["1","2","3","4","5","6","7","8",],
//         "h" => ["1","2","3","4","5","6","7","8",],
//     ];

//     public static function getRookAccesibleCells ($opts = []) {

//         $rookVertical = $opts["rookPosition"]["vertical"];
//         $rookHorizontal = $opts["rookPosition"]["horizontal"];
//         $accessibleCells = [];

//         foreach (self::CELLS[$rookVertical] as $curVertCellNum) {
//             if ($curVertCellNum != $rookHorizontal) {
//                 $curCell = "{$rookVertical}{$curVertCellNum}";
//                 $accessibleCells[] = $curCell;
//             }
//         }
//         foreach (array_keys(self::CELLS) as $curHorCellName) {
//             if ($curHorCellName != $rookVertical) {
//                 $curCell = "{$curHorCellName}{$rookHorizontal}";
//                 $accessibleCells[] = $curCell;
//             }
//         }

//         return $accessibleCells;

//     }

// }

// var_dump(ChessBoard::getRookAccesibleCells($actualPose->rooks[0]->position));

