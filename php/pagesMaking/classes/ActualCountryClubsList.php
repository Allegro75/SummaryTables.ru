            
<?

class ActualCountryClubsList
{

    private $db;

    public function __construct($opts = [])
    {
        $pathToRoot = $opts["pathToRoot"];
        require_once "{$pathToRoot}database/config/config.php";
        require_once "{$pathToRoot}database/config/connect.php";
        $this->db = connect();
    }

    // Получение списка клубов данной страны (с ранжиром по числу сезонов в еврокубках)
    public function getActualCountryClubsList($opts = [])
    {

        $basicRangeClubs = $opts["clubsList"];
        $countryCode = $opts["countryCode"];
        return $countryCode;

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

        mysqli_close($this->db);

        return $history;
        
    }

}
