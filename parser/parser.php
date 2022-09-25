
<?

// $arr = [
//     'yes' => 1,
//     'message' => 2,
// ];

$clubs = json_decode(file_get_contents('php://input'), true);

// echo json_encode($arr);
// echo json_encode($_POST['body']);
// echo json_encode($_POST);
echo json_encode($clubs);

