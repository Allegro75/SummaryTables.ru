
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
];

// include_once("Piece.php");
include_once("PiecesSet.php");

// $wRook_a7 = new Rook(["position" => $actualPosition["whitePiecesPositions"]["rooks"][0]]);

$actualPicesSet = new PiecesSet(["actualPosition" => $actualPosition]);

echo "<pre>";
// var_dump($actualPosition);
// var_dump($wRook_a7->getName());
// var_dump($wKing_h6->getName());
// var_dump($wRook_a7->getPosition());
// var_dump($wRook_a7->getAccesibleCells());
// var_dump($wKing_h6->getAccesibleCells());
// var_dump($bKing_h8->getAccesibleCells());
// var_dump($wKing_h6->getColor());
// var_dump($bKing_h8->getColor());
var_dump($actualPicesSet);
var_dump($actualPicesSet->actualPiecesSet["whites"]["king"]->getAccesibleCells());
// var_dump($actualPicesSet->actualPiecesSet["blacks"]["king"]->getAccesibleCells());
// var_dump($actualPicesSet->actualPiecesSet["whites"]["rooks"][0]->getAccesibleCells());
