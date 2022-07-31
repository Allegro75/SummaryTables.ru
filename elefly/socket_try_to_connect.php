<!--  Простейший файл для подключения вебсокета -->

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elefly</title>
</head>
<body>

    <script>
        
        document.addEventListener(`DOMContentLoaded`, () => {

            // Вебсокет:
            let socket = new WebSocket("wss://summarytables.ru/elefly/socket_2.php");
            // let socket = new WebSocket("wss://demo.piesocket.com/v3/channel_1?api_key=VCXCEuvhGcBDP7XhiJJUDvR1e1D3eiVjgZ9VRiaV&notify_self"); // Тестовый сервис
            socket.addEventListener("open", () => {
                console.log("We are connected");
                socket.send(JSON.stringify({'newWord' : "бубу"}));    
            });
            socket.addEventListener("message", (e) => {
                console.log(e.data);
            })
         
        })

    </script>

</body>
</html>