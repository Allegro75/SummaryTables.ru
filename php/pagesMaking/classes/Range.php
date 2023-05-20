            
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

        // $sql = 
        //     "SELECT `clubName`, `clubId`,
        //     SUM(`mainRangeMark`) AS `mainRangeMarksSum`, 
        //     MAX(CASE WHEN `mainRangeMark` > 0 THEN `tourneyFinalYear` END) AS `lastTourney`
        //     FROM `clubs_achievements`
        //     GROUP BY `clubId`
        //     {$minMarkClause}
        //     ORDER BY `mainRangeMarksSum` DESC, `lastTourney` DESC
        // ";
        // if ($res = mysqli_query($this->db, $sql)) {
        //     while ($row = mysqli_fetch_assoc($res)) {
        //         $range[] = $row;
        //         // $clubInfo["sql"] = $sql;
        //     }
        // }

        // $sql = 
        //     "SELECT `t1`.`clubName`, `t1`.`clubId`, `t1`.`points`, `t1`.`lastTourney`, `clubs_achievements`.{$marksField} AS `lastMark`
        //     FROM
        //     (
        //         SELECT `clubName`, `clubId`,
        //         SUM({$marksField}) AS `points`, 
        //         MAX(CASE WHEN {$marksField} > 0 THEN `tourneyFinalYear` END) AS `lastTourney`
        //         FROM `clubs_achievements`
        //         WHERE 1 = 1
        //         {$earliestRangeYearClause}
        //         GROUP BY `clubId`
        //     ) 
        //     AS `t1`
        //     JOIN `clubs_achievements`
        //     ON `clubs_achievements`.`clubId` = `t1`.`clubId`
        //     WHERE `clubs_achievements`.`tourneyFinalYear` = `t1`.`lastTourney`
        //     GROUP BY `t1`.`clubId`
        //     ORDER BY `t1`.`points` DESC, `t1`.`lastTourney` DESC, `lastMark` DESC
        //     LIMIT {$clubsNumber}
        // ";

        // $sql = 
        //     "SELECT `clubName`, `clubId`,
        //     SUM(`mainRangeMark`) AS `mainRangeMarksSum`, 
        //     MAX(CASE WHEN `mainRangeMark` > 0 THEN `tourneyFinalYear` END) AS `lastTourney`
        //     FROM `clubs_achievements`
        //     GROUP BY `clubId`
        //     {$minMarkClause}
        //     ORDER BY `mainRangeMarksSum` DESC, `lastTourney` DESC
        // ";

        // if ($res = mysqli_query($this->db, $sql)) {
        //     while ($row = mysqli_fetch_assoc($res)) {
        //         $range[] = $row;
        //         // $clubInfo["sql"] = $sql;
        //     }
        // }


        $rangeInfo = $this->getRange(["range" => "basic", "clubsNumber" => 100,]);        

        // $info["range"] = $range;
        $info["range"] = $range = $rangeInfo["range"];
        // echo "<pre>";
        // var_dump($rangeInfo);
        // echo "</pre>";        

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

    public function getRange ($opts = []) { // Пробуем сделать более универсальный (не зависящий от того, флормируем мы периодический или базовый ранжир, и если периодический, то на какой период) метод получения ранжира клубов.

        $info = $rangeInfo = [];

        $range = $opts["range"];
        $subrange = $opts["subrange"];
        $clubsNumber = $opts["clubsNumber"];

        if ($range === "periodic") {
            $marksField = "`actualPeriodsMark`";
        }
        elseif ($range === "basic") {
            $marksField = "`mainRangeMark`";
        }

        $earliestRangeYearClause = "";
        if ($range === "periodic") {
            $earliestRangeYear = $subrange["periodStartYear"];
            $earliestRangeYearClause = "AND `tourneyFinalYear` >= {$earliestRangeYear}";
        }

        $sql = 
            "SELECT `t1`.`clubName`, `t1`.`clubId`, `t1`.`points`, `t1`.`lastTourney`, `clubs_achievements`.{$marksField} AS `lastMark`
            FROM
            (
                SELECT `clubName`, `clubId`,
                SUM({$marksField}) AS `points`, 
                MAX(CASE WHEN {$marksField} > 0 THEN `tourneyFinalYear` END) AS `lastTourney`
                FROM `clubs_achievements`
                WHERE 1 = 1
                {$earliestRangeYearClause}
                GROUP BY `clubId`
            ) 
            AS `t1`
            JOIN `clubs_achievements`
            ON `clubs_achievements`.`clubId` = `t1`.`clubId`
            WHERE `clubs_achievements`.`tourneyFinalYear` = `t1`.`lastTourney`
            GROUP BY `t1`.`clubId`
            ORDER BY `t1`.`points` DESC, `t1`.`lastTourney` DESC, `lastMark` DESC
            LIMIT {$clubsNumber}
        ";
        var_dump($sql);
        if ($res = mysqli_query($this->db, $sql)) {
            while ($row = mysqli_fetch_assoc($res)) {
                $clubName = $row["clubName"];
                $rangeInfo[$clubName] = $row;
            }              
        }

        $info["range"] = $rangeInfo;

        return $info;

    }

}    