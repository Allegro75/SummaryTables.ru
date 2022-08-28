<?php

// Шахматные фигуры, их свойства
abstract class Piece
{

    protected $color = "white";
    public $position;

    public function __construct ($opts = []) {

        if (isset($opts["color"]) && (in_array($opts["color"], ["black", "white"]))) {
            $this->color = $opts["color"];
        }

        $this->position = $opts["position"];

    }

    // abstract public function getName();
    public function getName()
    {
        return $this->name;
    }

    // public function setColor($color)
    // {
    //     $this->color = $color;
    // }

    public function getColor()
    {
        return $this->color;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function getPositionNotation()
    {
        $vertical = $this->position["vertical"];
        $horizontal = $this->position["horizontal"];
        return "{$vertical}{$horizontal}";
    }

    // Все поля шахматной доски:
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

    // Обозначения фигур в нотации:
    const DESIGNATIONS = [
        "king" => "K",
        "queen" => "Q",
        "rook" => "R",
        "bishop" => "B",
        "knight" => "N",
        "pawn" => "p",
    ];

}

class King extends Piece
{

    protected $name = "king";

    // Получение полей, доступных для короля
    // Пока без учёта возможных препятствий на пути короля (всегда получаем от 3 до 8 полей в зависимости от позиции короля)
    public function getAccessibleCells ($opts = []) {

        $position = $this->position;
        $kingVertical = $position["vertical"]; // вертикаль, на к-рой находится король
        $kingHorizontal = $position["horizontal"]; // горизонталь, на к-рой находится король
        $accessibleCells = [];

        // Формируем набор актуальных для следующего хода короля вертикалей (в количестве от 2 до 3):
        if (true) {            
            // Индекс верткали, занимаемой королём в массиве вертикалей:
            $kingVertIndex = array_search($kingVertical, array_keys(self::CELLS));
            $actualVertIndexes = [$kingVertIndex - 1, $kingVertIndex, $kingVertIndex + 1];
        }

        // Формируем набор актуальных для следующего хода короля горизонталей (в количестве от 2 до 3):
        if (true) {
            $actualHorizontals = [];
            $actualHorizontals = [$kingHorizontal - 1, $kingHorizontal, $kingHorizontal + 1];
            // return $actualHorizontals;
        }
        
        $kingPositionCell = "{$kingVertical}{$kingHorizontal}";
        foreach ($actualVertIndexes as $curVertIndex) {
            $curVertName = isset(array_keys(self::CELLS)[$curVertIndex]) ? array_keys(self::CELLS)[$curVertIndex] : null;
            if (isset($curVertName)) {
                foreach ($actualHorizontals as $curHorNum) {
                    if (($curHorNum >= 1) && ($curHorNum <= 8)) {
                        $curCell = "{$curVertName}{$curHorNum}";
                        if ($curCell !== $kingPositionCell) {
                            $accessibleCells[] = $curCell;
                        }
                    }
                }
            }
        }

        return $accessibleCells;

    }    

}

class Rook extends Piece
{

    protected $name = "rook";

    // Получение полей, доступных для ладьи
    // Пока без учёта возможных препятствий на пути ладьи (всегда получаем 14 полей)
    public function getAccessibleCells ($opts = []) {

        $position = $this->position;
        $rookVertical = $position["vertical"]; // вертикаль, на к-рой находится ладья
        $rookHorizontal = $position["horizontal"]; // горизонталь, на к-рой находится ладья
        $accessibleCells = [];

        // Перебираем поля на вертикали нахождения ладьи
        foreach (self::CELLS[$rookVertical] as $curVertCellNum) {
            if ($curVertCellNum != $rookHorizontal) {
                $curCell = "{$rookVertical}{$curVertCellNum}";
                $accessibleCells[] = $curCell;
            }
        }
        // Перебираем вертикали доски
        foreach (array_keys(self::CELLS) as $curVertName) {
            if ($curVertName != $rookVertical) {
                $curCell = "{$curVertName}{$rookHorizontal}";
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

