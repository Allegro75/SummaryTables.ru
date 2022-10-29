            
<?

require_once '../../../database/config/config.php';
require_once '../../../database/config/connect.php';

// Основная задача объекта класса Club - возвращать масссив с информацией о конкретном клубе, получаемый запросом в `eurocups_clubs`
class Club {

    private $db;

    public function __construct()
    {
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
        if ($result = mysqli_query($this->db, $sql)) {
            if ($row = mysqli_fetch_assoc($result)) {
                $clubInfo = $row;
            }              
        }

        return $clubInfo;

    }


}    