<?php
    class User {
        //db properties
        private $conn; //connection
        private $table = 'users'; //db table name

        //set users properties
        public $id;
        public $fullname;
        public $username;
        public $email;
        public $password;
        public $register_date;

        //pass db to constructer 
        public function __construct($db){
            $this->conn = $db;
        }

        //insert new user
        public function create(){
            //query(named parameter)
            $query = 'INSERT INTO '. $this->table .' 
                SET 
                fullname = :fullname, 
                username = :username, 
                email = :email, 
                password = :password
            ';

            // query for username ane email validation
            $query_username = 'SELECT username FROM '. $this->table .' WHERE username = :username';
            $query_email = 'SELECT email FROM '. $this->table .' WHERE email = :email';
            // if(empty($fullname) && empty($username) && empty($email) && empty($password)) {
            //     die('Could not get data: ' . mysql_error());
            // };

            // $query = 'INSERT INTO '. $this->table .' 
            //     SET 
            //     fullname = :fullname, 
            //     username = :username, 
            //     email = :email, 
            //     password = :password
            // ';

            //prepare statement
            $stmt = $this->conn->prepare($query);
            $chk_username = $this->conn->prepare($query_username);
            $chk_email = $this->conn->prepare($query_email);

            //clean data up
            $this->fullname = htmlspecialchars(strip_tags($this->fullname));
            $this->username = htmlspecialchars(strip_tags($this->username));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->password = md5($this->password); //password security

            //bind data
            $stmt->bindParam(':fullname', $this->fullname);
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $this->password);
            //bind data for checking
            $chk_username->bindParam(':username', $this->username);
            $chk_email->bindParam(':email', $this->email);

            //execute query
            $chk_username->execute();
            $chk_email->execute();

            if($chk_username->rowCount() > 0) {
                die('Could not save data: username already exist');
            } else if ($chk_email->rowCount() > 0) {
                die('Could not save data: email already exist');
            }

            if($stmt->execute()) {
                return true;
            }

            //print error if anything goes wrong
            printf("ERROR: %s.\n", $stmt->error);
            return false;
        }

        // read / view users
        public function read() {
            // create query
            $query = 'SELECT * FROM ' . $this->table . ' ORDER BY register_date ASC';

            // create prepare statement
            $stmt = $this->conn->prepare($query);

            //execute statement
            $stmt->execute();

            return $stmt;
        }
    }
?>