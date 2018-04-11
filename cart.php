<?php
/**
 * Created by PhpStorm.
 * User: Iris
 * Date: 10-4-2018
 * Time: 14:44
 */
include "head.php";
include "navbar.php";

print_r($_SESSION['cart']);

$sql="SELECT * FROM product";