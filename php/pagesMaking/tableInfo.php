            
<?

require_once "classes/Club.php";

function getTableInfo ($opts = []) {

    $rawClubsList = $opts['clubsList'];

    $info = [];
    // $info['rawClubsList'] = $rawClubsList;

    $clubsList = [];
    foreach (array_keys($rawClubsList) as $curClubName) {
        $newClub = new Club(['pathToRoot' => "../../"]);
        $clubsList[$curClubName] = $newClub->getClubByName();
    }
    $info['clubsList'] = $clubsList;



    return $info;

}        