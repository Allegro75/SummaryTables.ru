            
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
                $range[$row["clubId"]] = $row;
                // $clubInfo["sql"] = $sql;
            }              
        }

        $info["range"] = $range;

        // $achieves = [];

        // $clNames = ["Кубок чемпионов", "Лига чемпионов"];

        // foreach ($range as $curClubId => $curClubInfo) {

        //     $achieves[$curClubId]["clubName"] = $curClubInfo["clubName"];
        //     $sql = 
        //         "SELECT `tourneyTitle`, `tourneyFinalYear`, `tourneyResult`, `mainRangeMark`
        //         FROM `clubs_achievements` 
        //         WHERE `clubId` = {$curClubId}
        //         AND `mainRangeMark` > 0
        //         ORDER BY `tourneyFinalYear`
        //     ";
        //     if ($res = mysqli_query($this->db, $sql)) {
        //         while ($row = mysqli_fetch_assoc($res)) {
        //             $isClAchieve = (in_array($row["tourneyTitle"], $clNames)) ? true : false;
        //             if ($isClAchieve === true) {
        //                 $achieves[$curClubId]["achieves"]["cl"][] = [
        //                     "tourneyTitle" => $row["tourneyTitle"],
        //                     "tourneyFinalYear" => $row["tourneyFinalYear"],
        //                     "tourneyResult" => $row["tourneyResult"],
        //                     "mainRangeMark" => $row["mainRangeMark"],
        //                 ];
        //             }                    
        //             elseif ($isClAchieve === false) {
        //                 $achieves[$curClubId]["achieves"]["el"][] = [
        //                     "tourneyTitle" => $row["tourneyTitle"],
        //                     "tourneyFinalYear" => $row["tourneyFinalYear"],
        //                     "tourneyResult" => $row["tourneyResult"],
        //                     "mainRangeMark" => $row["mainRangeMark"],
        //                 ];
        //             }                    
        //         }              
        //     }                        

        // }

        // $info["achieves"] = $achieves;

        return $info;

    }


}    