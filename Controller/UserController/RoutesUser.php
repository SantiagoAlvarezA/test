<?php
header("Content-Type: application/json; charset=utf-8");
//header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require_once 'UserController.php';
$user = new UserController;


switch ($_SERVER["REQUEST_METHOD"]) {
    case 'GET':
        $_REQUEST ?  $user->show($_REQUEST['id']) : $user->get();
        break;
    case 'POST':
        $body = json_decode(file_get_contents("php://input"));
        $user->post($body);
        break;
    case 'DELETE':
        $id = $_REQUEST['id'];
        $user->delete($id);
        break;
    case 'PUT':
        $id = $_REQUEST['id'];
        $body = json_decode(file_get_contents("php://input"));
        $user->put($id, $body);
        break;
}
