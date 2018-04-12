<?php
/**
 * Created by PhpStorm.
 * User: Iris
 * Date: 6-3-2018
 * Time: 15:34
 */

session_start();
session_destroy();
header('Location: index.php');
exit();