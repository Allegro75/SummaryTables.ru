            
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

        // Определяем статистику:
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
        $result = mysqli_query($this->db, $sql);
        $matchesArr = array();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $matchesArr[] = $row;
            }
        }
        $noHistory = false;
        if (count($matchesArr) === 0) {
            $noHistory = true;
        }
        $history = count($matchesArr);

        return $history;

    }


}    