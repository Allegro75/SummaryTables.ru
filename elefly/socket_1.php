#!/usr/bin/env php
<?php

// $socket = stream_socket_server("tcp://0.0.0.0:8000", $errno, $errstr);
$socket = stream_socket_server("tcp://127.0.0.1:2000", $errno, $errstr);
if (!$socket) {
    die("$errstr ($errno)\n");
}
while ($connect = stream_socket_accept($socket, -1)) {
    fwrite($connect, "HTTP/1.1 200 OK\r\nContent-Type: text/html\r\nConnection: close\r\n\r\nСпартак");
    fclose($connect);
}
fclose($socket);


// $SecWebSocketAccept = base64_encode(pack('H*', sha1($SecWebSocketKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
// $response = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
//     "Upgrade: websocket\r\n" .
//     "Connection: Upgrade\r\n" .
//     "Sec-WebSocket-Accept:$SecWebSocketAccept\r\n\r\n";


// $socket = stream_socket_server("tcp://0.0.0.0:8000", $errno, $errstr);
// if (!$socket) {
//   echo "$errstr ($errno)<br />\n";
// } else {
//   while ($conn = stream_socket_accept($socket)) {
//     fwrite($conn, 'Локальное время ' . date('n/j/Y g:i a') . "\n");
//     fclose($conn);
//   }
//   fclose($socket);
// }