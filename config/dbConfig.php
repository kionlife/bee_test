<?php

session_start();
class dbConnect {
    private $server = 'localhost';
    private $user = 'kionl667_bee';
    private $password = 'Bee@455000';
    private $dbName = 'kionl667_bee';
    public $db_conn;

    public function __construct() {
        $this->db_conn = mysqli_connect($this->server, $this->user, $this->password, $this->dbName);
        if (!$this->db_conn){
            die(mysqli_connect_error($this->db_conn));
        }
    }
}