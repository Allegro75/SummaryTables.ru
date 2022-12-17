            
<?

require_once "classes/Club.php";
// spl_autoload('classes/Club.php');
require_once "classes/PairMatchesHistory.php";

// Получение основных данных, необходимых для отображения сводных таблиц: суммарной статитстике встреч в парах клубов и информации о клубах
function getTableInfo ($opts = []) {

    $rawClubsList = $opts['clubsList'];
    $rawActualCountryClubsList = $opts['actualCountryClubsList'];

    $info = [];

    // Получение массива клубов с полной информацией о них из `eurocups_clubs`:
    $clubsList = [];
    foreach (array_keys($rawClubsList) as $curClubName) {
        $newClub = new Club(['pathToRoot' => "../../"]);
        $clubsList[$curClubName] = $newClub->getClubByName(["clubName" => $curClubName]);
    }
    $info['clubsList'] = $clubsList;

    if ( ! (empty($rawActualCountryClubsList)) ) { // Получение такого же, как и выше массива клубов, но представляющих данную страну для национальных таблиц:
        $actualCountryClubsList = [];
        foreach (array_keys($rawActualCountryClubsList) as $curClubName) {
            $newClub = new Club(['pathToRoot' => "../../"]);
            $actualCountryClubsList[$curClubName] = $newClub->getClubByName(["clubName" => $curClubName]);
        }
        $info['actualCountryClubsList'] = $actualCountryClubsList;
    }

    { // Получение массива ($pairsMatchesHistory) с краткими (представляемыми в итоговой таблице) данными о противостояниях:

        $pairsMatchesHistory = [];

        $outerCycleClubsList = ( ! (empty($actualCountryClubsList)) ) ? $actualCountryClubsList : $clubsList; // Определяем массив клубов для перебора во внешнем (первом) цикле. Для национальных таблиц - это клубы актуальной страны, для остальных - те же клубы, что и во внутреннем переборе.

        foreach ($outerCycleClubsList as $clubName => $clubInfo) { // Перебираем массив клубов

            foreach ($clubsList as $innerCycleClubName => $innerCycleClubInfo) { // Для каждого клуба снова перебираем массив клубов, определяя таким образом рассматриваемые конкретные пары клубов
                
                if ($clubName !== $innerCycleClubName) { // Естественно, отбрасываем совпадения перебираемых имён клубов, чтобы пара содержала два разных клуба

                    $pairName = "{$clubName} - {$innerCycleClubName}";
                    $newPairHistory = new PairMatchesHistory(['pathToRoot' => "../../"]);
                    $pairsMatchesHistory[$pairName] = $newPairHistory->getBasicTableHistory(["firstClub" => $clubInfo, "secClub" => $innerCycleClubInfo,]); // Передаю всю инфу о клубах данной пары, хотя, возможно, достаточно их id.

                }

            }

        }

    }

    $info['pairsMatchesHistory'] = $pairsMatchesHistory;

    return $info;

}        