<?php
    // db conn class
    class Database {
        // local db parameters
        // private $host = "localhost";
        // private $db_name = "schooladvisor";
        // private $username = "root";
        // private $password = "freshpeter498";
        // private $conn;

        // private $root_url = "http://localhost/phpsandbox/sidehustle-tasks/team6-dbcoll/";

        // deployed db parameters
        private $host = "remotemysql.com";
        private $db_name = "KEqGNcRqrp";
        private $username = "KEqGNcRqrp";
        private $password = "6PHX00Mtmd";
        private $conn;

        private $root_url = "https://sh6-userdb.herokuapp.com/";

        //connect to db
        public function connect() {
            //set connect variable to null
            $this->conn = null;

            //PDO OBJECT
            try{
                $this->conn = new PDO('mysql:host='.
                $this->host . ';dbname='.
                $this->db_name, $this->username, $this->password);
                //set error
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo "Connection Error: ". $e->getMessage();
            }

            return $this->conn;
        }
    }
?>