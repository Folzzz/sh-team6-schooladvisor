<?php
    // db conn class
    class Database {
        // db parameters
        private $host = "localhost";
        private $db_name = "schooladvisor";
        private $username = "root";
        private $password = "freshpeter498";
        private $conn;

        private $root_url = "http://localhost/phpsandbox/sidehustle-tasks/team6-dbcoll/";

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