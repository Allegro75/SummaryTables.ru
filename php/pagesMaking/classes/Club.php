            
<?

// Основная задача объекта класса Club - возвращать (методом getClubByName) масссив с информацией о конкретном клубе, получаемый запросом в `eurocups_clubs`
class Club {

    private $db;

    public function __construct($opts = [])
    {
        $pathToRoot = $opts["pathToRoot"];
        require_once "{$pathToRoot}database/config/config.php";
        require_once "{$pathToRoot}database/config/connect.php";
        $this->db = connect();       
    }

    public function getClubByName ($opts = []) {

        $clubName = $opts["clubName"];

        $clubInfo = [];

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

        return $clubInfo;

    }


}    