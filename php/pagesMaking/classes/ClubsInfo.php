            
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

        return $tourneyEndYear;

        

        $sql = 
            "SELECT * 
            FROM `eurocups_clubs` 
            WHERE basicFullName = '{$clubName}' 
            OR altNames = '{$clubName}' 
            OR altNames LIKE '{$clubName},%' 
            OR altNames LIKE '%,{$clubName}' 
            OR altNames LIKE '%,{$clubName},%'
        ";
        if ($res = mysqli_query($this->db, $sql)) {
            if ($row = mysqli_fetch_assoc($res)) {
                $clubInfo = $row;
                // $clubInfo["sql"] = $sql;
            }              
        }

        return $info;

    }


}    