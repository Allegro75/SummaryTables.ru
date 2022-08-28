
<?

$actualPosition = [
    "piecesPositions" => [
        "whitePiecesPositions" => [
            "king" => [
                "vertical" => "h",
                "horizontal" => "6",
            ],
            "rooks" => [
                0 => [
                    "vertical" => "a",
                    "horizontal" => "7",
                ],
            ],
        ],
        "blackPiecesPositions" => [
            "king" => [
                "vertical" => "h",
                "horizontal" => "8",
            ],
        ],
    ],
    "moveColor" => "whites", // очередь хода
];

// include_once("Piece.php");
include_once("ActualPosition.php");

// $wRook_a7 = new Rook(["position" => $actualPosition["whitePiecesPositions"]["rooks"][0]]);

$actualPosition = new ActualPosition(["actualPosition" => $actualPosition]);

echo "<pre>";
// var_dump($actualPosition);
// var_dump($wRook_a7->getName());
// var_dump($wKing_h6->getName());
// var_dump($wRook_a7->getPosition());
// var_dump($wRook_a7->getAccessibleCells());
// var_dump($wKing_h6->getAccessibleCells());
// var_dump($bKing_h8->getAccessibleCells());
// var_dump($wKing_h6->getColor());
// var_dump($bKing_h8->getColor());
// var_dump($actualPosition);
// var_dump($actualPosition->actualPiecesSet);
// var_dump($actualPosition->actualPiecesSet["whites"]["king"]->getAccessibleCells());
// var_dump($actualPosition->actualPiecesSet["blacks"]["king"]->getAccessibleCells());
// var_dump($actualPosition->actualPiecesSet["whites"]["rooks"][0]->getAccessibleCells());
// var_dump($actualPosition->actualPosition["moveColor"]);
// var_dump($actualPosition->getMoveColor());
var_dump($actualPosition->getAvailableMoves());
