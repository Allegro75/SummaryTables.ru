<?

include_once("Piece.php");

// Шахматная позиция - конкретный набор фигур (отсылающий к свойствам фигур из Piece)
class PiecesSet
{

    protected $actualPosition;
    protected $actualPiecesSet;

    public function __construct($opts=[])
    {
        
        $this->actualPosition = $opts["actualPosition"];        

        // Формируем набор фигур для актуальной позиции:
        $actualPiecesSet = [];
        foreach ($opts["actualPosition"] as $piecesColor => $curColorPiecesSet) {

            // var_dump($piecesColor);
            if ($piecesColor === "whitePiecesPositions") {
                $curPieceColorIndex = "whites";
                $curPieceColor = "white";
            } elseif ($piecesColor === "blackPiecesPositions") {
                $curPieceColorIndex = "blacks";
                $curPieceColor = "black";
            }
            // var_dump($curPieceColorIndex);
            
            foreach($curColorPiecesSet as $curPieceName => $curPiecePosition) {
                // var_dump($curPieceName);
                if ($curPieceName === "king") {
                    // var_dump("yes");
                    $actualPiecesSet[$curPieceColorIndex]["king"] = new King(["color" => $curPieceColor, "position" => $curPiecePosition]);
                }

            }

        }
        $this->actualPiecesSet = $actualPiecesSet;

    }

}