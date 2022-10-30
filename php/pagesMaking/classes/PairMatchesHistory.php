            
<?

// Получение данных об истории противостояний конкретной пары клубов
class PairMatchesHistory {

    private $db;

    public function __construct($opts = [])
    {
        $pathToRoot = $opts["pathToRoot"];
        require_once "{$pathToRoot}database/config/config.php";
        require_once "{$pathToRoot}database/config/connect.php";
        $this->db = connect();       
    }

    // Получение данных для представления в большинстве таблиц (таблиц типа history.html)
    public function getBasicTableHistory ($opts = []) {

        $firstClub = $opts["firstClub"];
        $secClub = $opts["secClub"];

        $firstClubId = $firstClub["id"];
        $secClubId = $secClub["id"];

        $history = [];

        // Определяем набор матчей данной пары:
        $sql =
            "SELECT * 
            FROM `matches` 
            WHERE 
                (
                        (
                            firstClubId = '{$firstClubId}' 
                            AND secondClubId = '{$secClubId}'
                        ) 
                    OR 
                        (
                            firstClubId = '{$secClubId}' 
                            AND secondClubId = '{$firstClubId}'
                        )
                )
            AND `score` != ''
        ";
        $matchesArr = array();
        if ($result = mysqli_query($this->db, $sql)) {        
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $matchesArr[] = $row;
                }
            }
        }
        $noHistory = false;
        if (count($matchesArr) === 0) {
            $noHistory = true;
        }
        // $history = count($matchesArr);

                // Про победы, ничьи, поражения:
                if (true) {

                    $firstVictories = 0;
                    $draws = 0;
                    for ($i = 0; $i < count($matchesArr); $i++) {
                        $draws += $matchesArr[$i]['fCDraw'];
                        if ($matchesArr[$i]['firstClubId'] == $firstClubId) {
                            $firstVictories += $matchesArr[$i]['fCVictory'];
                        } else {
                            $firstVictories += $matchesArr[$i]['fCLesion'];
                        }
                    }
                    $firstLesions = count($matchesArr) - $firstVictories - $draws;
                    $history = [
                        "firstVictories" => $firstVictories,
                        "draws" => $draws,
                        "firstLesions" => $firstLesions,
                    ];

                    // Про разницу мячей:
                    $firstGoals = 0;
                    $secondGoals = 0;
                    for ($i = 0; $i < count($matchesArr); $i++) {
                        if ($matchesArr[$i]['firstClubId'] == $firstClubId) {
                            $firstGoals += $matchesArr[$i]['firstClubGoals'];
                            $secondGoals += $matchesArr[$i]['secondClubGoals'];
                        } else {
                            $firstGoals += $matchesArr[$i]['secondClubGoals'];
                            $secondGoals += $matchesArr[$i]['firstClubGoals'];
                        }
                    }
                    $history["firstGoals"] = $firstGoals;
                    $history["secondGoals"] = $secondGoals;

                }        

        return $history;

    }


}    