<?php

namespace Helper;

use \PDO;
use Helper\Logger;

class DBHelper
{
    private $conn;
    private $sql;

    public function __construct()
    {
        try {

            $this->sql = '';

            $this->conn = new \PDO("mysql:host=" . SERVERNAME . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            // set the PDO error mode to exception
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            //$this->logger->critical();
            Logger::log("Connection failed: " . $e->getMessage());
        }
    }

    public function select($fields = '*')
    {
        $this->sql .= 'SELECT ' . $fields . ' ';

        return $this;
    }

    public function from($table)
    {
        $this->sql .= 'FROM ' . $table . ' ';
        return $this;
    }

    public function where($field, $value, $operator = '=')
    {
        $this->sql .= 'WHERE ' . $field . " ". $operator . ' "' . $value . '" ';
        return $this;
    }

    public function andWhere($field, $value, $operator = '=')
    {
        $this->sql .= 'AND ' . $field . " " . $operator . ' "' . $value . '" ';
        return $this;
    }

    public function orWhere($field, $value, $operator = '=')
    {
        $this->sql .= 'OR ' . $field . " " . $operator . ' "' . $value . '" ';
        return $this;
    }

    public function get()
    {
        $rez = $this->exec();
        return $rez->fetchAll();
    }

    public function delete()
    {
        $this->sql .= 'DELETE ';
        return $this;
    }

    public function insert($table, $data)
    {
        $this->sql .= "INSERT INTO " . $table . " (" . implode(", ", array_keys($data)) . ") VALUES ('" . implode("', '", $data) . "')";

        return $this;
    }

    public function orderBy($column, $order = "DESC")
    {
        $this->sql .= " ORDER BY " . $column . " " . $order . " ";

        return $this;
    }

    public function update($table, $data)
    {
        $update = "";
        foreach ($data as $column => $value) {
            $update .= $column . " = '" . $value . "', ";
        }
        $update = trim($update, ", ");

        $this->sql .= "UPDATE " . $table . " SET " . $update . " ";

        return $this;
    }

    public function exec()
    {
        if(DEBUG_MODE) {
            Logger::log($this->sql);
        }
        return $this->conn->query($this->sql);
    }

    public function getOne()
    {
        $rez = $this->exec();
        $data = $rez->fetchAll();

        if (!empty($data)) {
            return $data[0];
        } else {
            return false;
        }
    }

    public function limit($number)
    {
        $this->sql .= " LIMIT " . $number;

        return $this;
    }
}