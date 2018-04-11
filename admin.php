<?php
/**
 * Created by PhpStorm.
 * User: Iris
 * Date: 9-4-2018
 * Time: 14:31
 **/
include "head.php";
include "navbar.php";
require 'vendor/autoload.php';
?>

<div class="container">
    <h2 class="text-center"><i>Gebruikersaccounts wijzigen/aanpassen</i></h2>
    <div class="col-xs-12 col-md-6">
        <form action="" method="post">
            <label class="search_users_menu">Selecteer een gebruiker:<select class="search_users_menu" name="users_list">
                    <?php
                    $sql="SELECT * FROM user";
                    $result=$conn->query($sql);
                    while($row=mysqli_fetch_array($result)){
                        ?>
                        <option><?php echo $row['username'];?></option>
                        <?php
                    }
                    ?>
                </select>
            </label>
            <input type="submit" name="search_users" value="Gebruiker zoeken" class="btn btn-primary">
        </form>
    </div>
    <div class="col-xs-12 col-md-6">
        <form action="" method="post">
            <?php
            if(isset($_POST['search_users'])){
                $user=$_POST['users_list'];
                $_SESSION['username']=$user;
                $sql2="SELECT * FROM user WHERE username='$user'";
                $result2=$conn->query($sql2);
                while($row2=mysqli_fetch_array($result2)) {
                    ?>
                    <input type="text" name="username" value="<?php echo $row2['username']; ?>"
                           placeholder="Gebruikersnaam">
                    <input type="text" name="first_name" value="<?php echo $row2['first_name']; ?>"
                           placeholder="Voornaam">
                    <input type="text" name="last_name" value="<?php echo $row2['last_name']; ?>"
                           placeholder="Achternaam">
                    <input type="text" name="street" value="<?php echo $row2['address']; ?>" placeholder="Straat">
                    <input type="number" name="housenumber" value="<?php echo $row2['housenumber']; ?>"
                           placeholder="Huisnummer">
                    <input type="text" name="zipcode" value="<?php echo $row2['zipcode']; ?>" placeholder="Postcode">
                    <input type="text" name="city" value="<?php echo $row2['city']; ?>" placeholder="Woonplaats">
                    <input type="email" name="email" value="<?php echo $row2['email']; ?>" placeholder="E-mailadres">
                    <input type="number" name="phonenumber" value="0<?php echo $row2['phonenumber']; ?>"
                           placeholder="Telefoonnummer">
                    <input type="checkbox" name="newsletter"
                           placeholder="Nieuwsbrief" <?php if ($row2['newsletter'] == 1) {
                        echo 'checked="checked"';
                    } ?>>
                    <input type="text" name="role" value="<?php echo $row2['role']; ?>" placeholder="Rol">
                    <input type="submit" name="edit_user" value="Wijzigingen opslaan" class="btn btn-success">
                    <input type="submit" name="delete_user" value="Gebruiker verwijderen" class="btn btn-danger">
                    <?php
                }
            }
            if (isset($_POST['edit_user'])) {
                $user=$_SESSION['username'];
                $username = $_POST['username'];
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $street = $_POST['street'];
                $housenumber = $_POST['housenumber'];
                $zipcode = $_POST['zipcode'];
                $city = $_POST['city'];
                $email = $_POST['email'];
                $phonenumber = $_POST['phonenumber'];
                $newsletter = $_POST['newsletter'];
                $role = $_POST['role'];

                $stmt = $conn->prepare("UPDATE user SET username=?, first_name=?, last_name=?, address=?, housenumber=?, zipcode=?, city=?, email=?, phonenumber=?, newsletter=?, role=? WHERE username='$user'");
                $stmt->bind_param("ssssisssiis", $username, $first_name, $last_name, $street, $housenumber, $zipcode, $city, $email, $phonenumber, $newsletter, $role);
                $stmt->execute();
//                      var_dump($stmt);
                if(!$stmt->execute()){
                    echo "Bericht versturen mislukt.";
                }
                echo "<meta http-equiv='refresh' content='0'>";
            }
            if (isset($_POST['delete_user'])) {
                $user=$_SESSION['username'];
                $sql3 = "DELETE FROM user WHERE username='$user'";
                $result3 = $conn->query($sql3);
                var_dump($sql3);
                if ($result3) {
                    echo "Gebruiker verwijderen gelukt.";
                    echo "<meta http-equiv='refresh' content='0'>";
                } else {
                    echo "Verwijderen mislukt.";
                }
            }
            ?>
        </form>
    </div>
</div>
