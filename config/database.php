<?php
/**
 * Copyright (C) 2018-2019 yihua. MIT License
 * User: Yihua
 * Date: 8/6/2017
 * Time: 2:54 PM
 */

include_once ('config.php');

class Database {

    private $link;
    private $host, $username, $password, $database;

    public function __construct(){
        $this->host        = DB_SERVER;
        $this->username    = DB_USERNAME;
        $this->password    = DB_PASSWORD;
        $this->database    = DB_DATABASE;

        $this->link = mysqli_connect($this->host, $this->username, $this->password,$this->database)
        OR die("There was a problem connecting to the database.");

        /* change character set to utf8 */
        if (!$this->link ->set_charset("utf8")) {
            printf("Error loading character set utf8: %s\n", $this->link ->error);
        }

        mysqli_select_db($this->link, $this->database)
        OR die("There was a problem selecting the database.");

        return true;
    }

    public function query($query) {
        $result = mysqli_query($this->link,$query);
        //if (!$result) die('Invalid query: ' . $this->link->error);
        return $result;
    }

    public function __destruct() {
        if($this->link){
           mysqli_close($this->link)
           OR die("There was a problem disconnecting from the database."); 
        }
    }

    public function mysqli_real_escape_string($string)
    {
        $result = mysqli_real_escape_string($this->link,$string);
        if (!$result) die('Invalid query: ' . $this->link->error);
        return $result;
    }

    public function error()
    {
        return $this->link->error;
    }

    public function insert_id()
    {
        return $this->link->insert_id;
    }

}