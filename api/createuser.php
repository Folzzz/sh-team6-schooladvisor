<?php

    //headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested- With');

    //import db conn and users model
    include_once '../config/db_conn.php';
    include_once '../model/User.php';

    //instantiate database and post object
    $database = new Database();
    //connection variable
    $db = $database->connect();

    $user = new User($db);

    //get posted data
    $data = json_decode(file_get_contents("php://input"));

    $user->full_name = $data->full_name;
    $user->username = $data->username;
    $user->email = $data->email;
    $user->password = $data->password;

    //create new user
    if ($user->create()){
        echo json_encode(
            array('Message' => 'User Created')
        );
    } else {
        echo json_encode(
            array('Message' => 'Could not Create User')
        );
    }

    

?>