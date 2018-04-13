<?php
/**
 * Created by PhpStorm.
 * User: Iris
 * Date: 6-3-2018
 * Time: 15:08
 */

//maakt de database-connectie
$servername = "localhost";
$username = "Iris";
$password = "0000";
$dbname = "PC4U";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("connection failed:" . $conn->connect_error);
}
