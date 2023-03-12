            
<?

require_once "classes/Range.php";
require_once "classes/Club.php";

// Получение данных, необходимых для отображения базового ранжира
function getRangeInfo ($opts = []) {

    $info = [];

    $newRange = new Range(['pathToRoot' => "../../"]);
    $rangeInfo = $newRange->getBasicRange(["minMark" => 8,]);
    $info["range"] = $rangeInfo["range"];
    $info["achieves"] = $rangeInfo["achieves"];

    foreach ($rangeInfo["range"] as $curClubInfo) {
        $newClub = new Club(['pathToRoot' => "../../"]);
        $clubsList[$curClubInfo["clubName"]] = $newClub->getClubByName(["clubName" => $curClubInfo["clubName"]]);
    }
    $info["clubsList"] = $clubsList;

    return $info;

}

// Получение ранжира по периоду
// UPD. Пробуем сделать тут универсальный метод, подходящий и для базового ранжира
function getPeriodicRangeInfo ($opts = []) {

    $info = [];

    $range = $opts["range"];
    $subrange = $opts["subrange"] ?? null;
    $clubsNumber = $opts["clubsNumber"];

    $newRange = new Range(['pathToRoot' => "../../"]);

    // if ($range === "periodic") {
        $rangeInfo = $newRange->getRange(["range" => $range, "subrange" => $subrange, "clubsNumber" => $clubsNumber,]);
    // }
    $info["range"] = $rangeInfo["range"];

    return $info;

}