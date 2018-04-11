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
    <h1 class="text-center">Registreren</h1>
    <br>
    <form action="" method="post">
        <input type="text" name="first_name" placeholder="Voornaam" required>
        <input type="text" name="last_name" placeholder="Achternaam" required>
        <input type="email" name="email" placeholder="E-mailadres" required>
        <input type="text" name="address" placeholder="Straatnaam" required>
        <input type="number" name="housenumber" placeholder="Huisnummer" required>
        <input type="text" name="zipcode" placeholder="Postcode" required>
        <input type="text" name="city" placeholder="Stad" required>
        <input type="tel" name="phonenumber" placeholder="Telefoonnummer" required>
        <input type="text" name="username" placeholder="Gebruikersnaam" required>
        <input type="password" name="password1" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$
" placeholder="Wachtwoord" required>
        <input type="password" name="password2" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$
" placeholder="Wachtwoord herhalen">
        <input type="hidden" name="newsletter" value="0">
        <label><input type="checkbox" name="newsletter" value="1">Nieuwsbrief</label>
        <input type="submit" name="signup_btn" value="Registreren" class="btn btn-primary">
    </form>
</div>

<?php
if(isset($_POST['signup_btn'])){
    $first_name=mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name=mysqli_real_escape_string($conn, $_POST['last_name']);
    $email=mysqli_real_escape_string($conn, $_POST['email']);
    $address=mysqli_real_escape_string($conn, $_POST['address']);
    $housenumber=mysqli_real_escape_string($conn, $_POST['housenumber']);
    $zipcode=mysqli_real_escape_string($conn, $_POST['zipcode']);
    $city=mysqli_real_escape_string($conn, $_POST['city']);
    $phonenumber=mysqli_real_escape_string($conn, $_POST['phonenumber']);
    $newsletter=mysqli_real_escape_string($conn, $_POST['newsletter']);
    $username=mysqli_real_escape_string($conn, $_POST['username']);
    $password1=mysqli_real_escape_string($conn, $_POST['password1']);
    $password2=mysqli_real_escape_string($conn, $_POST['password2']);
    $hashed_password = $crypt->create($password1);
    $role = "user";

    if($password1==$password2) {

        $sql = "INSERT INTO user (username, password, first_name, last_name, address, housenumber, zipcode, city, email, phonenumber, newsletter, role) 
                VALUES ('$username', '$hashed_password', '$first_name', '$last_name', '$address', '$housenumber', '$zipcode', '$city', '$email', '$phonenumber', '$newsletter', '$role') ";
        $result = $conn->query($sql);
//        var_dump($sql);
        echo mysqli_error($conn);
        if ($result) {
            $_SESSION['username']=$username;
            $_SESSION['first_name']=$first_name;
            var_dump($sql);
//            header('Location: index.php');
//            exit();
        } else {
            echo "Registreren mislukt!";
        }
    }else echo "Wachtwoorden komen niet overeen!";
}
$conn->close();
?>

<?php
include "footer.php";
?>
