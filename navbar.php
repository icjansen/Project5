<?php
/**
 * Created by PhpStorm.
 * User: Iris
 * Date: 6-3-2018
 * Time: 14:38
 */
session_start();
?>
<body>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">PC4U</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="#">Lorem ipsum</a></li>
                <li><a href="#">Lorem ipsum</a></li>
                <li><a href="#">Lorem ipsum</a></li>
                <li><a href="#">Lorem ipsum</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php
                if(isset($_SESSION['first_name'])){
                    echo '
                          <p class="logged_in"><a href="account.php">Welcome '.$_SESSION['first_name'].'!</a>'.'
                          <a href="logout.php" class="btn btn-success">Uitloggen</a></p>';
                }else{
                   echo '
                    <li><a href="signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                    <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                    ';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
