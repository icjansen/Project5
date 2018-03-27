<?php
/**
 * Created by PhpStorm.
 * User: Iris
 * Date: 6-3-2018
 * Time: 14:42
 */
include "head.php";
include "navbar.php";
require 'vendor/autoload.php';

$crypt = new \Zend\Crypt\Password\Bcrypt();
?>

<div class="container">
    <h1 class="text-center">Inloggen</h1>
    <br>
    <form action="" method="post">
        <input type="text" name="username" placeholder="Gebruikersnaam" required>
        <input type="password" name="password" placeholder="Wachtwoord" required>
        <input type="submit" name="login_btn" value="Submit" class="btn btn-primary">
    </form>
</div>

<?php
if(isset($_POST['login_btn'])){
    $username=mysqli_real_escape_string($conn, $_POST['username']);
    $password=mysqli_real_escape_string($conn, $_POST['password']);

    $sql="SELECT * FROM user WHERE username='$username'";
    $result=$conn->query($sql);
    if(mysqli_num_rows($result)==0){
        echo "Gebruikersnaam bestaat niet.";
    }
    while ($row = mysqli_fetch_array($result)) {
        $first_name=$row['first_name'];
        $db_password = $row['password'];

        if ($crypt->verify($password, $db_password)) {
            $_SESSION['username'] = $username;
            $_SESSION['first_name']=$first_name;
            echo "Login successful!";
            $_SESSION['username']=$username;
            header('Location: index.php');
            exit();
        } else {
            echo "Failed to login";
        }
    }
}$conn->close();
?>

<?php
include "footer.php";
?>
