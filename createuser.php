<?php

    //headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested- With');

    //import db conn and users model
    include_once 'config/db_conn.php';
    include_once 'model/User.php';

    //instantiate database and user object
    $database = new Database();
    //connection variable
    $db = $database->connect();

    $user = new User($db);

    //get posted data
    $data = json_decode(file_get_contents("php://input"));
    if(empty($data->fullname) || empty($data->username) || empty($data->email) || empty($data->password)) {
        die('Could not save data: some fields are empty');
    } else if (!filter_var($data->email, FILTER_VALIDATE_EMAIL)) {
        die('Could not save data: wrong email format');
    }
    else {
        $user->fullname = $data->fullname;
        $user->username = $data->username;
        $user->email = $data->email;
        $user->password = $data->password;
    }
        // $user->fullname = $data->fullname;
        // $user->username = $data->username;
        // $user->email = $data->email;
        // $user->password = $data->password;
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