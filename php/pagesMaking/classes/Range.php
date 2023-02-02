            
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
            "SELECT `clubName`, `clubId`, SUM(`mainRangeMark`) AS `mainRangeMarksSum`
            FROM `clubs_achievements`
            GROUP BY `clubId`
            {$minMarkClause}
            ORDER BY `mainRangeMarksSum` DESC, `tourneyFinalYear` DESC
        ";
        if ($res = mysqli_query($this->db, $sql)) {
            if ($row = mysqli_fetch_assoc($res)) {
                $range[] = $row;
                // $clubInfo["sql"] = $sql;
            }              
        }

        $info["range"] = $range;

        return $info;

    }


}    