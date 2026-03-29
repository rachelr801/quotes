<?php
    class Database{
        //DB params
        private $host = "rwquotes.iceiy.com";
		private $db_name = " icei_41502759_quotesdb";
		private $username = "icei_41502759";
		private $password = "4SKJiZRhy6xf";
        
        // DB connect
        public function connect() {
            $conn = null;

            try {
                $conn = new PDO(
                    "mysql:host=$this->host;dbname=$this->db_name",
                     $this->username,
                     $this->password
                );
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e){
                echo json_encode(["message" => $e->getMessage()]);
            }

            return $conn;
        }
    }