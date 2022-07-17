<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elefly</title>
</head>
<body>
    
    <?php

        $currentMoveNumber = $_COOKIE["currentMoveNumber"] ?? 0;
        setcookie("currentMoveNumber", $currentMoveNumber + 1);

        $currentWord = $_COOKIE["newWord"] ?? "";
        $wordToShow = mb_strtoupper($currentWord);

        if ( ! (empty($currentWord))) {
            setcookie("oldWord-{$currentMoveNumber}", $currentWord);
        }

    ?> 

    <div class="content">

        <div>
            <div>Текущее слово:</div>
            <div class='current-word' style="max-width: 300px; min-height: 30px; border: solid 1px; border-radius: 3px; padding: 10px; font-size: 24px; letter-spacing: 0.2em;">
                <?=$wordToShow?>
            </div>
        </div>

        <!-- <form action="" style="margin-top: 10px;"> -->
        <div style="margin-top: 10px;">
        
            <div class='new-word'>
                <label for='new-word__word'>Новое слово:</label>
                <input type='text' class='new-word__word' id='new-word__word' name='word' style="min-height: 30px;">
            </div>

            <div class='submit' style="margin-top: 5px;">
                <div type='submit' class='submit-btn' id="submit-btn" style="border: solid 1px; border-radius: 3px; width: 100px; padding: 3px; text-align: center;">
                    Отправить
                </div>
            </div>

        <!-- </form> -->
        </div>

        <div id="gameCourse">            
        </div>

    </div>

    <script>
        document.addEventListener(`DOMContentLoaded`, () => {
            const wordInput = document.getElementById(`new-word__word`);            
            document.getElementById(`submit-btn`).addEventListener(`click`, (e) => {
                const newWord = wordInput.value;
                console.log(newWord);
                document.cookie = `newWord=${newWord}; path=summarytables.ru/elefly;`
                location.reload();
            })
        })
    </script>

</body>
</html>