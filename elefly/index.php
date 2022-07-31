<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elefly</title>
</head>
<body>

    <div class="content">

        <div>
            <div>Текущее слово:</div>
            <div class='current-word' style="max-width: 300px; min-height: 30px; border: solid 1px; border-radius: 3px; padding: 10px; font-size: 24px; letter-spacing: 0.2em;">
                <?=$wordToShow?>
            </div>
        </div>

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

        </div>

        <div id="gameCourse">            
        </div>

    </div>

    <!-- Для обработки клика на кнопку "Отправить" -->
    <script>
        
        document.addEventListener(`DOMContentLoaded`, () => {

            const wordInput = document.getElementById(`new-word__word`);

            // Для обработки клика на кнопку "Отправить":    
            document.getElementById(`submit-btn`).addEventListener(`click`, (e) => {
                const newWord = wordInput.value;
                // console.log(newWord);
                document.cookie = `newWord=${newWord}; path=summarytables.ru/elefly;`
                // location.reload();
            })

            // Вебсокет:
            let socket = new WebSocket("wss://summarytables.ru/elefly/socket_1.php");
            // let socket = new WebSocket("wss://demo.piesocket.com/v3/channel_1?api_key=VCXCEuvhGcBDP7XhiJJUDvR1e1D3eiVjgZ9VRiaV&notify_self"); // Тестовый сервис
            socket.addEventListener("open", () => {
                console.log("We are connected");
                console.log(wordInput.value);
                socket.send(JSON.stringify({'newWord' : wordInput.value,}));    
            });
            socket.addEventListener("message", (e) => {
                console.log(e.data);
            })

        })
    </script>

    <!-- Код с whatsapp.qr: -->
    <!-- document.getElementById(`getQrBtnDiv-<?=$counter?>`).addEventListener(`click`, () => {

    document.getElementById(`wait_please-<?=$counter?>`).classList.remove(`d-none`);
    const ws = new WebSocket("wss://vds2300205.my-ihor.ru:3000/qrcode");
    var point = <?=$this->point?>;
    var num = '<?=$curPhone?>';
    ws.addEventListener("open", () => {
        console.log("We are connected");
        ws.send(JSON.stringify({'point':point,'num': num}));                        
    });
    let haveQrStrGot = false;
    ws.addEventListener("message", (e) => {  
        if (haveQrStrGot === false) {                      
            console.log(e.data);
            let msg = JSON.parse(e.data)
            const qrStr = msg["qr"] ? msg["qr"] : "";
            if (qrStr) {
                console.log(qrStr);
                haveQrStrGot = true;
                showQrCode(qrStr);
            }
        }                                                  
    });                            

    })     -->

</body>
</html>