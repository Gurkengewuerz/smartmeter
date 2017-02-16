<?php

class MySQL {

    public $MySQLiObj;
    public $state;

    public function __construct() {
        $config = array("DB" => array("host" => "127.0.0.1", "user" => "username", "pass" => "examplepassword", "db" => "smartmeter", "port" => 3306));
        $this->MySQLiObj = new \mysqli($config["DB"]["host"], $config["DB"]["user"], $config["DB"]["pass"], $config["DB"]["db"], $config["DB"]["port"]);
        if ($this->MySQLiObj->connect_errno) {
            $this->error(array("code" => "MY_CONNECT_" . $this->MySQLiObj->connect_errno, "msg" => "Could not connect to MySQL Server:<br />" . $this->MySQLiObj->connect_error));
            $this->state = false;
            return;
        }
        $this->query("SET NAMES utf8");
        $this->state = true;
    }

    private function error($error) {
        var_dump($error);
    }

    public function __destruct() {
        if (!$this->state)
            return;
        $this->MySQLiObj->close();
    }

    public function query($sqlQuery, $resultset = false) {
        $result = $this->MySQLiObj->query($sqlQuery);
        if ($resultset == true) {
            return $result;
        }
        $return = $this->makeArrayResult($result);
        return $return;
    }

    public function multi_query($sqlQuery, $resultset = false) {
        $result = $this->MySQLiObj->multi_query($sqlQuery);
        if ($resultset == true) {
            return $result;
        }
        $return = $this->makeArrayResult($result);
        return $return;
    }

    public function escapeString($value) {
        return $this->MySQLiObj->real_escape_string($value);
    }

    public function getInsertId() {
        return $this->MySQLiObj->insert_id;
    }

    public function printLastSQLError() {
        $this->error(array("code" => "MY_QUERY_" . $this->MySQLiObj->errno, "msg" => $this->MySQLiObj->error));
    }

    public function lastSQLError() {
        return $this->MySQLiObj->error;
    }

    private function makeArrayResult($ResultObj) {
        if ($ResultObj === false) {
            return false;
        } else if ($ResultObj === true) {
            return true;
        } else if ($ResultObj->num_rows == 0) {
            return array();
        } else {
            $array = array();
            while ($line = $ResultObj->fetch_array(MYSQLI_ASSOC)) {
                array_push($array, $line);
            }
            return $array;
        }
    }

}
