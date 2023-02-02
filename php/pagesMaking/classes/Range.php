            
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

        return $info;

    }


}    