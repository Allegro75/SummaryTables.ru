<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elefly</title>
</head>
<body>
    
    <?php

        $currentWord = $_COOKIE["newWord"] ?? "";
        $wordToShow = mb_strtoupper($currentWord);

    ?> 

    <div class="content">

        <div>
            <div>Текущее слово:</div>
            <div class='current-word' style="max-width: 300px; min-height: 20px; border: solid 1px; border-radius: 3px;">
                <?=$wordToShow?>
            </div>
        </div>

        <form action="" style="margin-top: 10px;">
            <div class='new-word'>
                <label for='new-word__word'>Новое слово:</label>
                <input type='text' class='new-word__word' id='new-word__word' name='word'>
            </div>

            <div class='submit' style="margin-top: 5px;">
                <button type='submit' class='submit-btn' id="submit-btn">
                    Отправить
                </button>
            </div>
        </form>

    </div>

    <script>
        document.addEventListener(`DOMContentLoaded`, () => {
            const wordInput = document.getElementById(`new-word__word`);
            const newWord = wordInput.value;
            document.getElementById(`submit-btn`).addEventListener(`submit`, (e) => {
                e.preventDefault();
                console.log(newWord);
                document.cookie = `newWord=${newWord}; path=summarytables.ru/elefly;`
                // document.cookie = `room=${newHallId}; path=/qr/<?=$pointId?>`;
            })
        })
    </script>

</body>
</html>