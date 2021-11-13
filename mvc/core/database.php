<?php
    class database {
        public $connect;
        public $host = DB_HOST;
        public $dbname = DB_NAME;
        public $username = DB_USER;
        public $password = DB_PASS;

        function __construct() {
            $this->connect = new PDO("mysql:host=$this->host; dbname=$this->dbname; charset=utf8", 
            $this->username, $this->password);   
        }
    }
?>