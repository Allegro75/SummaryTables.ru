            
<?

// Получение правильных форм слов русского языка в зависимости от падежа и т.п.
class WordForms
{

    // Получение правильной формы слова типа "победа" (женский род, окончание на "а") после числительного
    public static function getWordLikePobeda($opts = [])
    {

        $number = $opts["number"];
        $word = $opts["word"];

        $wordBase = mb_substr($word, 0, (mb_strlen($word) - 1)); // Основа, корень слова. Это слово без последнего символа (например, "побед" для исходного слова "победа")
        $victoriesWord = $wordBase;
        if ($number == 1) {
            $victoriesWord = $word;
        } else if (($number >= 2) && ($number <= 4)) {
            $victoriesWord = "{$wordBase}ы";
        }
        
        return $victoriesWord;

    }

    // То же самое, что и getWordLikePobeda, но с более коректным названием метода
    // Получение правильной формы слова типа "победа" (женский род, окончание на "а") после числительного
    public static function getWordLikeVictory($opts = [])
    {

        $number = $opts["number"];
        $word = $opts["word"];

        $wordBase = mb_substr($word, 0, (mb_strlen($word) - 1)); // Основа, корень слова. Это слово без последнего символа (например, "побед" для исходного слова "победа")
        $victoriesWord = $wordBase;
        if ($number == 1) {
            $victoriesWord = $word;
        } else if (($number >= 2) && ($number <= 4)) {
            $victoriesWord = "{$wordBase}ы";
        }
        
        return $victoriesWord;

    }

    // Получение правильной формы слова типа "ничья" (женский род, окончание на "я") после числительного
    public static function getWordLikeDraw($opts = [])
    {

        $number = $opts["number"];
        $word = $opts["word"];

        $wordBase = mb_substr($word, 0, (mb_strlen($word) - 1)); // Основа, корень слова. Это слово без последнего символа (например, "ничь" для исходного слова "ничья")
        $drawWord = "{$wordBase}их";
        if ($number === 1) {
            $drawWord = $word;
        } else if (($number >= 2) && ($number <= 4)) {
            $drawWord = "{$wordBase}и";
        }
        
        return $drawWord;

    }

    // Получение правильной формы слова типа "дуэль" (женский род, окончание на "ь") после числительного
    public static function getWordLikeDuel($opts = [])
    {

        $number = $opts["number"];
        $word = $opts["word"];

        $wordBase = mb_substr($word, 0, (mb_strlen($word) - 1)); // Основа, корень слова. Это слово без последнего символа (например, "дуэл" для исходного слова "дуэль")
        $newWord = "{$wordBase}ей";
        if (($number !== 11) && (($number % 10) === 1)) {
            $newWord = $word;
        } else if (($number != 12) && ($number != 13)  && ($number != 14) && ((($number % 10) === 2)) || (($number % 10) === 3) || (($number % 10) === 4)) {
            $newWord = "{$wordBase}и";
        }
        
        return $newWord;    

    }

    // Получение правильной формы слова типа "поражение" (средний род) после числительного
    public static function getWordLikeLesion($opts = [])
    {

        $number = $opts["number"];
        $word = $opts["word"];

        $wordBase = mb_substr($word, 0, (mb_strlen($word) - 1)); // Неизменяемая основа слова. Это слово без последнего символа (например, "поражени" для исходного слова "поражение")
        $newWord = "{$wordBase}й";
        if ($number === 1) {
            $newWord = $word;
        } else if (($number >= 2) && ($number <= 4)) {
            $newWord = "{$wordBase}я";
        }
        
        return $newWord;

    }

    // Получение правильной формы слова типа "очко" (средний род) после числительного
    public static function getWordLikePoint($opts = [])
    {

        $number = $opts["number"];
        $word = $opts["word"];

        $wordBase = mb_substr($word, 0, (mb_strlen($word) - 1)); // Неизменяемая основа слова. Это слово без последнего символа (например, "очк" для исходного слова "очко")
        $newWord = "{$wordBase}ов";
        if ((($number % 10) === 1) && (($number !== 11) && ($number !== 111) && ($number !== 211) && ($number !== 311))) {
            $newWord = $word;
        } else if ( ( (($number % 10) === 2) || (($number % 10) === 3) || (($number % 10) === 4) ) && ( ! (in_array($number, [12, 13, 14, 112, 113, 114, 212, 213, 214, 312, 313, 314,])) ) ) {
            $newWord = "{$wordBase}а";
        }
        
        return $newWord;

    }

    // Получение правильной формы слова типа "финал" (мужской род) после числительного
    public static function getWordLikeFinal($opts = [])
    {

        $number = $opts["number"];
        $word = $opts["word"];

        $newWord = "{$word}ов";
        if ((($number % 10) === 1) && (($number !== 11) && ($number !== 111) && ($number !== 211) && ($number !== 311))) {
            $newWord = $word;
        } else if ( ( (($number % 10) === 2) || (($number % 10) === 3) || (($number % 10) === 4) ) && ( ! (in_array($number, [12, 13, 14, 112, 113, 114, 212, 213, 214, 312, 313, 314,])) ) ) {
            $newWord = "{$word}а";
        }
        
        return $newWord;

    }

    // Получение правильной формы названия клуба в родительном падеже (нужно для описания дуэлей):
    // Слово в среднем роде (напр., "Челси") не нуждается в изменениях в родительном падеже.
    public static function getGenitiveWord($opts = [])
    {

        $gender = $opts["gender"];
        $word = $opts["word"];

        if ((mb_strpos($word, " ") !== false) && ($word !== "Црвена звезда") && ($word !== "Астон Вилла") && ($word !== "Реал Сосьедад")) { // Для названий типа "Боруссия Д", "Динамо К"

            $clubNameWordsArr = explode(" ", $word);
            $justClubName = $clubNameWordsArr[0];
            $cityPart = $clubNameWordsArr[1];

            $clubNameCorrForm = self::getGenitiveWord(["word" => $justClubName, "gender" => $gender,]);
            return ["clubNameCorrForm" => $clubNameCorrForm, "cityPart" => $cityPart,];

        } else { // Для большинства названий клубов

            if ($gender === "neuter") {
                return $word;
            }

            elseif ($gender === "male") {

                if (mb_substr($word, (mb_strlen($word) - 1), 1) === "ь") { // Если последний символ это "ь" (напр., для слова "Ливерпуль")
                    $wordBase = mb_substr($word, 0, (mb_strlen($word) - 1)); // Неизменяемая основа слова. Это слово без последнего символа (например, "Ливерпул" для исходного слова "Ливерпуль"
                    return "{$wordBase}я"; // Например, "Ливерпуля"
                } else {
                    return "{$word}а"; // Например, "Реала"
                }

            }

            elseif ($gender === "female") {

                if ($word === "Црвена звезда") {
                    return "Црвены звезды";
                }

                else { // Для всех (в женском роде), кроме "Црвены звезды"

                    $wordBase = mb_substr($word, 0, (mb_strlen($word) - 1)); // Неизменяемая основа слова. Это слово без последнего символа (например, "Барселон" для исходного слова "Барселона"

                    if (mb_substr($word, (mb_strlen($word) - 2), 2) === "ка") { // Если последние два символ это "ка" (напр., для слова "Бенфика")
                        return "{$wordBase}и"; // Например, "Бенфики"
                    } elseif (mb_substr($word, (mb_strlen($word) - 1), 1) === "а")  {
                        return "{$wordBase}ы"; // Например, "Барселоны"
                    } elseif (mb_substr($word, (mb_strlen($word) - 1), 1) === "я")  { // Например, "Валенсия"
                        return "{$wordBase}и"; // Например, "Валенсии"
                    }

                }

            }

        }

    }    

}
