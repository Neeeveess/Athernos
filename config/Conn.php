<?php
    abstract class Conn
    {   
        public $conn;

        public function connUser(){
            $this->conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        }
    }
        // public function connAdm(){
        //     $this->conn = new mysqli('localhost','athernos','L3MK%Ah-qYy','athernos');
        // }

        // public function validador(){
        //     session_start();
        //     if($_SESSION['nivel']==2){
        //         $this->connAdm();
        //     }elseif($_SESSION['nivel']==0){
        //         $this->connUser();
        //     }

        // }
        // }


    
    // $host = 'localhost';
    // $user = 'root';
    // $pass = '';
    // $db = 'athernos';

    // $conn = new mysqli($host,$user,$pass,$db);
?>