<?php 

function db_connect() {
    $connection = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    confirm_db_connect($connection);
    return $connection;
}

function confirm_db_connect($connection) {
    if($connection->connect_errno) {
        $msg = "Database failed connection: ";
        $msg .= $connection->connect_error;
        $msg .= " (" . $connection->connect_errno . ")";
        exit($msg);
    }
}