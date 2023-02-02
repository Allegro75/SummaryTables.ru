            
<?

require_once "classes/Range.php";
require_once "classes/Club.php";

// Получение данных, необходимых для отображения ранжира
function getRangeInfo ($opts = []) {

    $info = [];

    $newRange = new Range(['pathToRoot' => "../../"]);
    $rangeInfo = $newRange->getBasicRange(["minMark" => 8,]);
    $info["range"] = $rangeInfo["range"];

    foreach ($rangeInfo["range"] as $curClubInfo) {
        $newClub = new Club(['pathToRoot' => "../../"]);
        $clubsList[$curClubInfo["clubName"]] = $newClub->getClubByName(["clubName" => $curClubInfo["clubName"]]);
    }
    $info["clubsList"] = $clubsList;

    return $info;

}        