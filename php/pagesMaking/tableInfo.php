            
<?

require_once "classes/Club.php";
// spl_autoload('classes/Club.php');

function getTableInfo ($opts = []) {

    $rawClubsList = $opts['clubsList'];

    $info = [];

    // Получение массива клубов с полной информацией о них из `eurocups_clubs`:
    $clubsList = [];
    foreach (array_keys($rawClubsList) as $curClubName) {
        $newClub = new Club(['pathToRoot' => "../../"]);
        $clubsList[$curClubName] = $newClub->getClubByName(["clubName" => $curClubName]);
    }
    $info['clubsList'] = $clubsList;

    // Получение массива ($pairsMatchesHistory) с краткими (представляемыми в итоговой таблице) данными о противостояниях:
    if (true) {

        $pairsMatchesHistory = [];
        foreach ($clubsList as $clubName => $clubInfo) { // Перебираем массив клубов

            foreach ($clubsList as $innerCycleClubName => $innerCycleClubInfo) { // Для каждого клуба снова перебираем массив клубов, определяя таким образом рассматриваемые конкретные пары клубов
                
                if ($clubName !== $innerCycleClubName) { // Естественно, отбрасываем совпадения перебираемых имён клубов, чтобы пара содержала два разных клуба

                    $pairName = "{$clubName} - {$innerCycleClubName}";

                    $pairsMatchesHistory[$pairName] = [];

                }

            }

        }

    }
    $info['pairsMatchesHistory'] = $pairsMatchesHistory;

    return $info;

}        