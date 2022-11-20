            
<?

// require_once("Stages.php");

class Matches {

    private $db;

    public function __construct($opts = [])
    {
        // $pathToRoot = $opts["pathToRoot"];
        // require_once "{$pathToRoot}database/config/config.php";
        // require_once "{$pathToRoot}database/config/connect.php";
        require_once "../../../database/config/config.php";
        require_once "../../../database/config/connect.php";
        $this->db = connect();       
    }

    // Получение пар клубов, играющих на определённой стадии турнира.
    // Актуально для таблиц с фаворитами незавершённых турниров.
    // Возвращает массив матчей последней на данный момент стадии турнира, имеющей записи в БД с незавершёнными матчами. Либо той стадии, к-рая передана как один из аргументов
    public function getActualStagePairs ($opts = []) {

        $tourneyTitle = $opts["tourneyTitle"];
        $tourneyFinalYear = $opts["tourneyFinalYear"];
        $stage = $opts["stage"] ?? false;

        // if ( ! ($stage) ) {
        //     $defaultStagesOrder = Stages::$stagesOrder;
        // }

        $stageOrScoreClause = ($stage !== false) ? "AND `tourneyStage` = '{$stage}'" : "AND `score = ''";

        $pairsFor = [];

        $sql = 
            "SELECT * 
            FROM `matches` 
            WHERE `tourneyTitle` = '{$tourneyTitle}' 
            AND `tourneyFinalYear` = '{$tourneyFinalYear}'
            {$stageOrScoreClause}
        ";
        if ($res = mysqli_query($this->db, $sql)) {
            while ($row = mysqli_fetch_assoc($res)) {
                $firstId = $row["firstClubId"];
                $secId = $row["secondClubId"];
                if ( ! (isset($pairsFor[$firstId])) ) {
                    $pairsFor[$firstId]["rival"]["id"] = $secId;
                }
                if ( ! (isset($pairsFor[$secId])) ) {
                    $pairsFor[$secId]["rival"]["id"] = $firstId;
                }
            }              
        }

        return $pairsFor;

    }


}    