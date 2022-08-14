
<?

// phpinfo();
// echo "Spartak";

$actualPosition = [
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
];

include_once("Piece.php");

$wRook_a7 = new Rook(["position" => $actualPosition["whitePiecesPositions"]["rooks"][0]]);


echo "<pre>";
// var_dump($actualPosition);
// var_dump($wRook_a7->getName());
var_dump($wRook_a7->getAccesibleCells());
