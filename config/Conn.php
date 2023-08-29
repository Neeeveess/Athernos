<?php
    abstract class Conn
    {   
        public $conn;

        public function connUser(){
            $this->conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        }
    }
?>