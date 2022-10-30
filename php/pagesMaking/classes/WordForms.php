            
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

}
