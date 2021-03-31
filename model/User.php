<?php
    class User {
        //db properties
        private $conn; //connection
        private $table = 'users'; //db table name

        //set users properties
        public $id;
        public $full_name;
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
                full_name = :full_name, 
                username = :username, 
                email = :email, 
                password = :password
            ';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //clean data up
            $this->full_name = htmlspecialchars(strip_tags($this->full_name));
            $this->username = htmlspecialchars(strip_tags($this->username));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->password = htmlspecialchars(strip_tags($this->password));

            //bind data
            $stmt->bindParam(':full_name', $this->full_name);
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $this->password);

            //execute query
            if($stmt->execute()) {
                return true;
            }

            //print error if anything goes wrong
            printf("ERROR: %s.\n", $stmt->error);
            return false;
        }
    }
?>