            
<?

class Tourneys {

    public static $tourneysProps = [

        "Лига чемпионов" => [
            "archiveFolderName" => "champ_league",
            "archiveFilePrefix" => "cl",   
            "genitiveForm" => "лиги чемпионов",
        ],

        "Лига Европы" => [
            "archiveFolderName" => "euroleague",
            "archiveFilePrefix" => "el",
            "genitiveForm" => "лиги Европы",
        ],

        "Кубок чемпионов" => [
            "archiveFolderName" => "champ_league",
            "archiveFilePrefix" => "cl",
            "genitiveForm" => "кубка чемпионов", 
        ],

        "Кубок кубков" => [
            "archiveFolderName" => "cup_win_cup",
            "archiveFilePrefix" => "cwc",
            "genitiveForm" => "кубка кубков",
        ],

        "Кубок УЕФА" => [
            "archiveFolderName" => "euroleague",
            "archiveFilePrefix" => "el",
            "genitiveForm" => "кубка УЕФА",
        ],        

        "Кубок ярмарок" => [
            "archiveFolderName" => "euroleague",
            "archiveFilePrefix" => "el",
            "genitiveForm" => "кубка ярмарок",
            "specialYears" => [
                1958 => [
                    "tourneyStartYear" => 1955,
                ],
                1960 => [
                    "tourneyStartYear" => 1958,
                ],
            ]
        ],        

    ];


}    