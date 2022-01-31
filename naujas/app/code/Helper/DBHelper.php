<?php
namespace Helper;

use PDO;

class DBHelper
{
    private $conn;
    private $sql;

    public function __construct(){
        try {
            $this->sql = '';

            $this->conn = new PDO("mysql:host=".SERVERNAME.";dbname=".DB_NAME, DB_USER, DB_PASS);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {

        }
    }

    public function select($fields = '*'){
        $this->sql .= 'SELECT '. $fields. ' ';

        return $this;
    }

    public function from($table) {
        $this->sql .= 'FROM '.$table. ' ';
        return $this;
    }

    public function where($field, $value, $operator = '=') {
        $this->sql .= 'WHERE '. $field.$operator.'"'.$value.'"';
        return $this;
    }

    public function get() {
        $rez = $this->conn->query($this->sql);
        return $rez->fetchAll();
    }

    public function delete() {
        $this->sql .= 'DELETE ';
        return $this;
    }

    public function insert($table, $data) {
        $this->sql .= "INSERT INTO ". $table . " (".implode(", ", array_keys($data)).") VALUES ('".implode("', '", $data)."')";

        return $this;
    }

    public function update() {

    }

    public function exec() {
        $this->conn->query($this->sql);
        return $this;
    }

    public function getOne() {
        $rez = $this->conn->query($this->sql);
        $data = $rez->fetch_all();

        return $data[0];
    }
}