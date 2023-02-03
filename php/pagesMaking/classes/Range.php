            
<?

class Range {

    private $db;

    public function __construct($opts = [])
    {
        $pathToRoot = $opts["pathToRoot"];
        require_once "{$pathToRoot}database/config/config.php";
        require_once "{$pathToRoot}database/config/connect.php";
        $this->db = connect();       
    }

    public function getBasicRange ($opts = []) {

        $info = $range = [];

        $minMark = $opts["minMark"] ?? false;
        $minMarkClause = "";
        if ( ! (empty($minMark)) ) {
            $minMarkClause = "HAVING `mainRangeMarksSum` >= {$minMark}";
        }

        $sql = 
            "SELECT `clubName`, `clubId`,
            SUM(`mainRangeMark`) AS `mainRangeMarksSum`, 
            MAX(CASE WHEN `mainRangeMark` > 0 THEN `tourneyFinalYear` END) AS `lastTourney`
            FROM `clubs_achievements`
            GROUP BY `clubId`
            {$minMarkClause}
            ORDER BY `mainRangeMarksSum` DESC, `lastTourney` DESC
        ";
        if ($res = mysqli_query($this->db, $sql)) {
            while ($row = mysqli_fetch_assoc($res)) {
                $range[] = $row;
                // $clubInfo["sql"] = $sql;
            }              
        }

        $info["range"] = $range;

        $achieves = [];

        $clNames = ["Кубок чемпионов", "Лига чемпионов"];

        $newClPointsExplanations = [
            12 => "wins",
            9 => "finals",
            6 => "semiFinals",
            3 => "qurterFinals",
        ];
        $oldCcPointsExplanations = [
            8 => "wins",
            6 => "finals",
            4 => "semiFinals",
            2 => "qurterFinals",
        ];
        $elPointsExplanations = [
            4 => "wins",
            3 => "finals",
            2 => "semiFinals",
            1 => "qurterFinals",
        ];

        foreach ($range as $curClubInfo) {

            $curClubId = $curClubInfo["clubId"];
            $achieves[$curClubId]["clubName"] = $curClubInfo["clubName"];
            foreach (["cl", "el"] as $curTourneyType) {
                $achieves[$curClubId]["achieves"][$curTourneyType] = 
                [
                    "wins" => [
                        "number" => 0,
                        "tourneys" => [],
                    ],
                    "finals" => [
                        "number" => 0,
                        "tourneys" => [],
                    ],
                    "semiFinals" => [
                        "number" => 0,
                        "tourneys" => [],
                    ],
                    "qurterFinals" => [
                        "number" => 0,
                        "tourneys" => [],
                    ],
                ];
            }
            $sql = 
                "SELECT `tourneyTitle`, `tourneyFinalYear`, `tourneyResult`, `mainRangeMark`
                FROM `clubs_achievements` 
                WHERE `clubId` = {$curClubId}
                AND `mainRangeMark` > 0
                ORDER BY `tourneyFinalYear`
            ";
            if ($res = mysqli_query($this->db, $sql)) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $isClAchieve = (in_array($row["tourneyTitle"], $clNames)) ? true : false;
                    if ($isClAchieve === true) {
                        // $achieves[$curClubId]["achieves"]["cl"]["tourneys"][] = [
                        //     "tourneyTitle" => $row["tourneyTitle"],
                        //     "tourneyFinalYear" => $row["tourneyFinalYear"],
                        //     "tourneyResult" => $row["tourneyResult"],
                        //     "mainRangeMark" => $row["mainRangeMark"],
                        // ];
                        if ($row["tourneyFinalYear"] <= 1999) {
                            $achieveStage = $oldCcPointsExplanations[$row["mainRangeMark"]];
                        }
                        elseif ($row["tourneyFinalYear"] >= 2000) {
                            $achieveStage = $newClPointsExplanations[$row["mainRangeMark"]];
                        }
                        $achieves[$curClubId]["achieves"]["cl"][$achieveStage]["number"]++;
                        $achieves[$curClubId]["achieves"]["cl"][$achieveStage]["tourneys"][] = [
                            "tourneyTitle" => $row["tourneyTitle"],
                            "tourneyFinalYear" => $row["tourneyFinalYear"],
                            "tourneyResult" => $row["tourneyResult"],
                            "mainRangeMark" => $row["mainRangeMark"],
                        ];                        
                    }                    
                    elseif ($isClAchieve === false) {
                        // $achieves[$curClubId]["achieves"]["el"]["tourneys"][] = [
                        //     "tourneyTitle" => $row["tourneyTitle"],
                        //     "tourneyFinalYear" => $row["tourneyFinalYear"],
                        //     "tourneyResult" => $row["tourneyResult"],
                        //     "mainRangeMark" => $row["mainRangeMark"],
                        // ];
                        // switch ($row["mainRangeMark"]) {
                        //     case 4:
                        //         $achieves[$curClubId]["achieves"]["el"]["totalInfo"]["wins"]["number"]++;
                        //         break;
                        //     case 3:
                        //         $achieves[$curClubId]["achieves"]["el"]["totalInfo"]["finals"]["number"]++;
                        //         break;
                        //     case 2:
                        //         $achieves[$curClubId]["achieves"]["el"]["totalInfo"]["semiFinals"]["number"]++;
                        //         break;
                        //     case 1:
                        //         $achieves[$curClubId]["achieves"]["el"]["totalInfo"]["qurterFinals"]["number"]++;
                        //         break;
                        // }
                        $achieveStage = $elPointsExplanations[$row["mainRangeMark"]];
                        $achieves[$curClubId]["achieves"]["el"][$achieveStage]["number"]++;
                        $achieves[$curClubId]["achieves"]["el"][$achieveStage]["tourneys"][] = [
                            "tourneyTitle" => $row["tourneyTitle"],
                            "tourneyFinalYear" => $row["tourneyFinalYear"],
                            "tourneyResult" => $row["tourneyResult"],
                            "mainRangeMark" => $row["mainRangeMark"],
                        ];
                    }                    
                }              
            }                        

        }

        $info["achieves"] = $achieves;

        return $info;

    }


}    