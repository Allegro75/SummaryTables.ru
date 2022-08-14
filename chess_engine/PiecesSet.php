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
        $actualPiecesSet = [];

        // Формируем набор фигур для актуальной позиции:
        foreach ($opts["actualPosition"] as $piecesColor) {

            if ($piecesColor === "whitePiecesPositions") {
                $curPieceColorIndex = "whites";
                $curPieceColor = "white";
            } elseif ($piecesColor === "blackPiecesPositions") {
                $curPieceColorIndex = "blacks";
                $curPieceColor = "black";
            }
            
            foreach($piecesColor as $curPieceName) {
                if ($curPieceName === "king") {
                    var_dump("yes");
                    $actualPiecesSet[$curPieceColorIndex][] = new King(["color" => $curPieceColor, "position" => $curPieceName["position"]]);
                }

            }

        }
        $this->actualPiecesSet = $actualPiecesSet;

    }

}