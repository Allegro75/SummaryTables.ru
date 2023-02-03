            
<?

class ClubsInfo {

    private $db;

    public function __construct($opts = [])
    {
        $pathToRoot = $opts["pathToRoot"];
        require_once "{$pathToRoot}database/config/config.php";
        require_once "{$pathToRoot}database/config/connect.php";
        $this->db = connect();       
    }

    // Получение данных о клубах, продолжающих участие в текущем сезоне розыгрыша еврокубков
    public function getСurrentSeasonClubsInfo ($opts = []) {

        $info = [];

        $tourneyEndYear = $opts['tourneyEndYear'];       

        $sql = 
            "SELECT DISTINCT(`firstClubId`), `firstClubName`, `tourneyTitle`
            FROM `matches`  
            WHERE tourneyFinalYear = {$tourneyEndYear}
            AND `score` = ''
            AND `firstClubId` != 1274
            UNION
            SELECT DISTINCT(`secondClubId`), `secondClubName`, `tourneyTitle`
            FROM `matches`  
            WHERE `tourneyFinalYear` = {$tourneyEndYear}
            AND `score` = ''
            AND `secondClubId` != 1274
        ";
        if ($res = mysqli_query($this->db, $sql)) {
            while ($row = mysqli_fetch_assoc($res)) {
                $info["clubsInfo"][] = $row;
            }              
        }

        return $info;

    }


}    