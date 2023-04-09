            
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
        $lastYear = $opts["lastYear"] ?? "";

        $clubsList = $clubsNamesByIds = $clubsIds = [];

        // mysqli_report(MYSQLI_REPORT_ERROR);
        // mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        // Определяем все клубы актуальной страны:
        $sql =
            "SELECT `id`,`basicFullName`
            FROM `eurocups_clubs`
            WHERE `countryEngCode` = '{$countryCode}'
        ";
        // var_dump($sql);
        // var_dump(mysqli_query($this->db, $sql));
        if ($result = mysqli_query($this->db, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $clubsNamesByIds[$row["id"]] = $row["basicFullName"];
                    $clubsIds[] = $row["id"];
                }
            }
        }
        // var_dump($clubsIds);

        if ( ! (empty($clubsIds)) ) { // Определяем число сезонов в еврокубках для каждого клуба:

            $lastYearClause = "";
            if (!(empty($lastYear))) {
                $lastYearClause = "AND `tourneyFinalYear` <= {$lastYear}";
            }

            foreach ($clubsIds as $curClubId) {

                $sql =
                    "SELECT COUNT(DISTINCT(`tourneyFinalYear`)) AS `seasons`
                    FROM `matches`
                    WHERE `firstClubId` = {$curClubId}
                    OR `secondClubId` = {$curClubId}
                    {$lastYearClause}
                ";
                // var_dump($sql);
                if ($result = mysqli_query($this->db, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($row["seasons"] > 0) {
                                $curClubName = $clubsNamesByIds[$curClubId];
                                $clubsList[$curClubName]["seasons"] = $row["seasons"];
                            }
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
