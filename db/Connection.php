<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/news_task/db/config.php";

class Connection
{
    public function connect()
    {
        global $DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME;
        try {
            $con = new PDO("mysql:host=" . $DB_HOST . ";" . "dbname=" . $DB_NAME, $DB_USER, $DB_PASSWORD);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $con;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}

$con = new Connection;
$con->connect();