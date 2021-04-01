<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    //import db conn and user model
    include_once 'config/db_conn.php';
    include_once 'model/User.php';

    //instantiate database and user object
    $database = new Database();
    //connection variable
    $db = $database->connect();

    $user = new User($db);

    //get users data
    $response = $user->read();

    //get row count
    $num = $response->rowCount();

    //check if users exist
    if($num > 0 ) {
        //post array
        // $users_arr = array();
        $users_arr['users'] = array();

        while($row = $response->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            // item for each user
            $user_item = array(
                'id' => $id,
                'full_name' => $full_name,
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'register_date' => $register_date
            );

            //push item to user array
            array_push($users_arr['users'], $user_item);

        }

        //change to json and output
        echo json_encode($users_arr);

    } else {
        //no user
        echo json_encode(
            array('Message' => 'No user found')
        );
    }
?>