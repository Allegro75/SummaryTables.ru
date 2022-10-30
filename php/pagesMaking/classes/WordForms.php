            
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
        if ($number === 1) {
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

    // Получение правильной формы названия клуба в родительном падеже (нужно для описания дуэлей):
    // Слово в среднем роде (напр., "Челси") не нуждается в изменениях в родительном падеже.
    public static function getGenitiveWord($opts = [])
    {

        $gender = $opts["gender"];
        $word = $opts["word"];

        if ($gender === "male") {
            if (mb_substr($word, (mb_strlen($word) - 1), 1) === "ь") { // Если последний символ это "ь" (напр., для слова "Ливерпуль")
                $wordBase = mb_substr($word, 0, (mb_strlen($word) - 1)); // Неизменяемая основа слова. Это слово без последнего символа (например, "Ливерпул" для исходного слова "Ливерпуль"
                return "{$wordBase}я"; // Например, "Ливерпуля"
            } else {
                return "{$word}а"; // Например, "Реала"
            }
        }
        elseif ($gender === "female") {
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
