            
<?

// require_once "classes/Club.php";
spl_autoload('Club');

function getTableInfo ($opts = []) {

    $rawClubsList = $opts['clubsList'];

    $info = [];
    // $info['rawClubsList'] = $rawClubsList;

    $clubsList = [];
    foreach (array_keys($rawClubsList) as $curClubName) {
        $newClub = new Club(['pathToRoot' => "../../"]);
        $clubsList[$curClubName] = $newClub->getClubByName(["clubName" => $curClubName]);
    }
    $info['clubsList'] = $clubsList;



    return $info;

}        