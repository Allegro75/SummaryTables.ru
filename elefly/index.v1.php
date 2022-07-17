<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elefly</title>
</head>
<body>
    
<?php

if (!isset($_POST['word']) OR $_POST['word'] === '') {
    $_POST['word'] = 'плоть';
}

$wordToShow = mb_strtoupper($_POST['word']);

echo "<div class='current-word'>{$wordToShow}</div>

<br>

<form action='' method='POST' enctype='multipart/form-data'>

<div class='new-word'>
    <label for='new-word__word'>Новое слово:</label>
    <input type='text' class='new-word__word' id='new-word__word' name='word'>
</div>

<div class='submit'>
    <a href='index?={$_POST['word']}'>
        <input type='submit' class='submit-btn' value='Отправить'>
    </a>
</div>

</form>";

?>

</body>
</html>