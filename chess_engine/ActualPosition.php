<?

include_once("Piece.php");
// namespace chess_engine;

// Шахматная позиция - конкретный набор фигур (отсылающий к свойствам фигур из Piece)
class ActualPosition
{

    public $actualPosition;
    public $actualPiecesSet;

    public function __construct($opts=[])
    {
        
        $this->actualPosition = $opts["actualPosition"];

        // Формируем набор фигур для актуальной позиции:
        $actualPiecesSet = [];
        foreach ($opts["actualPosition"]["piecesPositions"] as $piecesColor => $curColorPiecesSet) {

            if ($piecesColor === "whitePiecesPositions") {
                $curPieceColorIndex = "whites";
                $curPieceColor = "white";
            } elseif ($piecesColor === "blackPiecesPositions") {
                $curPieceColorIndex = "blacks";
                $curPieceColor = "black";
            }
            
            foreach($curColorPiecesSet as $curPieceNameInPosDescr => $curPieceInfo) {

                // var_dump($curPieceNameInPosDescr);
                if ($curPieceNameInPosDescr === "king") {
                    $actualPiecesSet[$curPieceColorIndex]["king"] = new King(["color" => $curPieceColor, "position" => $curPieceInfo]);
                } else {
                    foreach ($curPieceInfo as $curOrdinaryPiece) {
                        $curPieceNameLength = mb_strlen($curPieceNameInPosDescr);
                        $curPieceName = mb_substr($curPieceNameInPosDescr, 0, $curPieceNameLength - 1);
                        // var_dump($curPieceName);
                        $curPieceNameFirstLetter = $cPNFL = mb_substr($curPieceName, 0, 1);
                        $cPNFLinUpperCase = mb_strtoupper($cPNFL);
                        $curPieceNameRestPart = mb_substr($curPieceName, 1);
                        $curPieceClassName = "{$cPNFLinUpperCase}{$curPieceNameRestPart}";
                        $actualPiecesSet[$curPieceColorIndex][$curPieceNameInPosDescr][] = new $curPieceClassName(["color" => $curPieceColor, "position" => $curOrdinaryPiece]);
                    }
                }

            }

        }
        $this->actualPiecesSet = $actualPiecesSet;

    }

    public function getMoveColor ($opts=[]) // Получение информации об очереди хода
    {

        return $this->actualPosition["moveColor"];

    }

    public function getAvailableMoves ($opts=[]) // Получение списка возможных ходов
    {

        $moveColor = $this->getMoveColor();
        foreach ($this->actualPiecesSet[$moveColor] as $curPieceNameInPosDescr => $curPieceInfo) {
            
        }

    }

}