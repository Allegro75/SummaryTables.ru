            
<?

// require_once "classes/Club.php";
// require_once "classes/PairMatchesHistory.php";

// Получение данных, необходимых для отображения ранжира
function getRangeInfo ($opts = []) {

    $info = [];

    $newRange = new Range(['pathToRoot' => "../../"]);
    $rangeInfo = $newRange->getBasicRange(["minMark" => 8,]);
    $info["range"] = $rangeInfo["range"];

    return $info;

}        