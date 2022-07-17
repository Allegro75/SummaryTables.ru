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

    <div>
        <div>Текущее слово:</div>
        <div class='current-word' style="min-width: 200px;">
            <?=$wordToShow?>
        </div>
    </div>

    <form action="">
        <div class='new-word'>
            <label for='new-word__word'>Новое слово:</label>
            <input type='text' class='new-word__word' id='new-word__word' name='word'>
        </div>

        <div class='submit'>
            <button type='submit' class='submit-btn' id="submit-btn" value='Отправить'>
        </div>
    </form>

    <script>
        document.addEventListener(`DOMContentLoaded`, () => {
            const wordInput = document.getElementById(`new-word__word`);
            const newWord = wordInput.value;
            document.getElementById(`submit-btn`).addEventListener(`submit`, () => {
                document.cookie = `newWord=${newWord}; path=/;`
                // document.cookie = `room=${newHallId}; path=/qr/<?=$pointId?>`;
            })
        })
    </script>

</body>
</html>