<?

include_once("Piece.php");
// namespace chess_engine;

// Шахматная позиция - конкретный набор фигур (отсылающий к свойствам фигур из Piece)
class PiecesSet
{

    public $actualPosition;
    public $actualPiecesSet;

    public function __construct($opts=[])
    {
        
        $this->actualPosition = $opts["actualPosition"];        

        // Формируем набор фигур для актуальной позиции:
        $actualPiecesSet = [];
        foreach ($opts["actualPosition"] as $piecesColor => $curColorPiecesSet) {

            if ($piecesColor === "whitePiecesPositions") {
                $curPieceColorIndex = "whites";
                $curPieceColor = "white";
            } elseif ($piecesColor === "blackPiecesPositions") {
                $curPieceColorIndex = "blacks";
                $curPieceColor = "black";
            }
            
            foreach($curColorPiecesSet as $curPieceName => $curPiecePosition) {
                // var_dump($curPieceName);
                if ($curPieceName === "king") {
                    $actualPiecesSet[$curPieceColorIndex]["king"] = new King(["color" => $curPieceColor, "position" => $curPiecePosition]);
                }

            }

        }
        $this->actualPiecesSet = $actualPiecesSet;

    }

}