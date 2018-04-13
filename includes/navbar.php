<?php
/**
 * Created by PhpStorm.
 * User: Iris
 * Date: 6-3-2018
 * Time: 14:38
 */
session_start();
//begin de sessie, navbar.php is een include op elke pagina dus hoeft de sessie maar 1 keer gestart te worden
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
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">Producten</a></li>
                <li><a href="store.php">Winkel</a></li>
                <li><a href="cart.php">Winkelwagen</a></li>
                <li><a href="admin.php">Admin</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php
                //wanneer de gebruiker is ingelogd, en de voornaam dus in de sessie staat, wordt de voornaam van de gebruiker
                // getoond, een link naar het account en een button om uit te loggen; wanneer de gebruiker niet is ingelogd,
                // worden er 2 buttons getoond (signup en login)
                if(isset($_SESSION['first_name'])){
                    echo '
                          <p class="logged_in"><a href="account.php">Welkom ' .$_SESSION['first_name'].'!</a>'. '
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
