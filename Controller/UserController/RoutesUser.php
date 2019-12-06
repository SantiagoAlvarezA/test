<?php
print_r(1234);
require_once 'UserController.php';

$user=new UserController;

switch($_SERVER["REQUEST_METHOD"]){
    case 'GET':
        $user->get();
    break;
    case 'POST':
        $user->post();
    break;
    case 'DELETE':  
        $user->delete();
    break;
    case 'PUT':
        $user->put();
    break;
}