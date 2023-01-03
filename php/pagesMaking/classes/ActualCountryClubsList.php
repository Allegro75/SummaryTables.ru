            
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

        $countryCode = $opts["countryCode"];

        $clubsList = $clubsNamesByIds = $clubsIds = [];

        // Определяем все клубы актуальной страны:
        $sql =
            "SELECT `id`,`basicFullName`
            FROM `eurocups_clubs`
            WHERE `countryEngCode` = '{$countryCode}'
        ";
        if ($result = mysqli_query($this->db, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // $clubsList[] = $row["basicFullName"];
                    $clubsNamesByIds[$row["id"]] = $row["basicFullName"];
                    $clubsIds[] = $row["id"];
                }
            }
        }

        if ( ! (empty($clubsIds)) ) { // Определяем число сезонов в еврокубках для каждого клуба:

            foreach ($clubsIds as $curClubId) {           

                $sql =
                    "SELECT COUNT(DISTINCT(`tourneyFinalYear`)) AS `seasons`
                    FROM `matches`
                    WHERE `firstClubId` = {$curClubId}
                    OR `secondClubId` = {$curClubId}
                ";
                if ($result = mysqli_query($this->db, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $curClubName = $clubsNamesByIds[$curClubId];
                            $clubsList[$curClubName]["seasons"] = $row["seasons"];
                        }
                    }
                }
            }

            // Сортировка клубов по числу сезонов в еврокубках:
            if ( ! (empty($clubsList)) ) {
                uasort($clubsList, function ($a, $b) {
                    return ($a["seasons"] > $b["seasons"]) ? -1 : 1;
                });
            }

        }

        mysqli_close($this->db);

        return $clubsList;

    }

}
