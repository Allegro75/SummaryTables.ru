            
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

        $clubsList = [];

        // Определяем набор матчей данной пары:
        // $sql =
        //     "SELECT `clubs`.`basicFullName`, COUNT(DISTINCT(`matches`.`tourneyFinalYear`)) AS `seasons`
        //     FROM `eurocups_clubs` AS `clubs`, `matches`
        //     GROUP BY `clubs`.`basicFullName`
        // ";
        $sql =
            "SELECT `basicFullName`
            FROM `eurocups_clubs`
            WHERE `countryEngCode` = '{$countryCode}'
        ";
        if ($result = mysqli_query($this->db, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $clubsList[] = $row["basicFullName"];
                }
            }
        }

        mysqli_close($this->db);

        return $clubsList;

    }

}
