<?php
/**
 * Created by PhpStorm.
 * User: Iris
 * Date: 14-3-2018
 * Time: 16:10
 */
include "./includes/head.php";
include "./includes/navbar.php";
require 'vendor/autoload.php';

$crypt = new \Zend\Crypt\Password\Bcrypt();

$username=$_SESSION['username'];

$sql="SELECT * FROM user WHERE username='$username'";//selecteer alles uit de tabel user waar de gebruikersnaam gelijk is aan de gebruikersnaam in de sessie(dus de ingelogde gebruiker)
$result=$conn->query($sql);
if(mysqli_num_rows($result)==0){
    header('Location: login.php');
    exit();
}
//var_dump($result);
while($row=mysqli_fetch_assoc($result)) {
    ?>

    <div class="container">
        <div class="col-xs-12 col-md-3 account_sidebar">
            <ul class="nav nav-tabs nav-stacked account_side_nav" id="myTab">
                <li class="active"><a data-toggle="tab" href="#home">Mijn gegevens</a></li>
                <li><a data-toggle="tab" href="#menu1">Bestellingen</a></li>
                <li><a data-toggle="tab" href="#menu2">Wachtwoord wijzigen</a></li>
                <li><a data-toggle="tab" href="#menu3">Berichten</a></li>
            </ul>
        </div>
        <div class="col-xs-12 col-md-9 account_main">
            <div class="tab-content">
                <!-- 1 active tab at a time! -->
                <div id="home" class="tab-pane fade in active">
                    <h2 class="text-center">Gegevens van <?php echo $row['username']; ?></h2>
                    <form action="" method="post"><!--form waarin de door de bovenstaande query gegevens getoond worden-->
                        <input type="text" name="first_name" placeholder="Voornaam" value="<?php echo $row['first_name']; ?>" required>
                        <input type="text" name="last_name" placeholder="Achternaam" value="<?php echo $row['last_name']; ?>" required>
                        <input type="email" name="email" placeholder="E-mailadres" value="<?php echo $row['email']; ?>" required>
                        <input type="text" name="address" placeholder="Straatnaam" value="<?php echo $row['address']; ?>" required>
                        <input type="number" name="housenumber" placeholder="Huisnummer" value="<?php echo $row['housenumber']; ?>" required>
                        <input type="text" name="zipcode" placeholder="Postcode" value="<?php echo $row['zipcode']; ?>" required>
                        <input type="text" name="city" placeholder="Stad" value="<?php echo $row['city']; ?>" required>
                        <input type="tel" name="phonenumber" placeholder="Telefoonnummer" value="0<?php echo $row['phonenumber']; ?>" required>

                        <?php
                        if($row['newsletter'] ==1){
                            $checked="checked";
                        }else {
                            $checked = "";
                        }
                        ?>
                        <input type="hidden" name="newsletter" value="0">
                        <label><input type="checkbox" name="newsletter" value="1" <?php echo $checked; ?>>Nieuwsbrief</label>
                        <input type="submit" name="change_btn" value="Wijzigen" class="btn btn-primary">
                    </form>
                </div>
                <?php
                if (isset($_POST['change_btn'])){
                    //met deze query wordt de inhoud van bovenstaand form opgeslagen in de database(een update van de tabel user)
                    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
                    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
                    $email = mysqli_real_escape_string($conn, $_POST['email']);
                    $address = mysqli_real_escape_string($conn, $_POST['address']);
                    $housenumber = mysqli_real_escape_string($conn, $_POST['housenumber']);
                    $zipcode = mysqli_real_escape_string($conn, $_POST['zipcode']);
                    $city = mysqli_real_escape_string($conn, $_POST['city']);
                    $phonenumber = mysqli_real_escape_string($conn, $_POST['phonenumber']);
                    $newsletter = mysqli_real_escape_string($conn, $_POST['newsletter']);

//                    $sql2 = "UPDATE user SET first_name = '$first_name', last_name = '$last_name', email = '$email', address = '$address', housenumber = '$housenumber', zipcode = '$zipcode', city = '$city', phonenumber = '$phonenumber', newsletter = '$newsletter' WHERE username = '$username'";
//                    $result2 = $conn->query($sql2);
//                    if($conn->query($sql2) === TRUE){
//                        echo "";
//                        echo "<meta http-equiv='refresh' content='0'>";
//                    }else{
//                        echo "Error: " . $sql2 . "<br>" . $conn->error;
//                    }

                    $stmt=$conn->prepare("UPDATE user SET first_name=?, last_name=?, email=?, address=?, housenumber=?, zipcode=?, city=?, phonenumber=?, newsletter=? WHERE username = '$username'");
                    $stmt->bind_param("ssssissii", $first_name, $last_name, $email, $address, $housenumber, $zipcode, $city, $phonenumber, $newsletter);
                    $stmt->execute();
                    echo "<meta http-equiv='refresh' content='0'>";
                }
                ?>
                <div id="menu1" class="tab-pane fade">
                    <h2 class="text-center">Bestellingen</h2>
                    <?php
                    //hier worden alle orders uit de tabel order opgehaald, waar de userID gelijk is aan de userID die hoort bij de ingelogde gebruikersnaam
                    $sql5="SELECT * FROM orders WHERE (SELECT username FROM user WHERE userID=orders.userID)='$username'";
                    $result5=$conn->query($sql5);
                    if($result5) {
                        while ($row5 = mysqli_fetch_assoc($result5)) {
                            ?>
                            <div class="btn btn-info col-xs-12" data-toggle="collapse"
                                data-target="#demo<?php echo $row5['orderID']; ?>">
                                <p class="col-xs-10 col-xs-offset-1">Ordernummer: <?php echo $row5['orderID']; ?></p>
                                <button class="btn btn-success col-xs-1" onclick="printDiv<?php echo $row5['orderID']; ?>()">Print</button><!--iedere functie is uniek, door het toevoegen van de orderID, hierdoor roept elke button alleen de printfunctie aan voor de bijbehorende order en dus niet voor de hele pagina-->
                                <script>
                                    function printDiv<?php echo $row5['orderID']; ?>() {
                                        window.frames["print_frame<?php echo $row5['orderID']; ?>"].document.body.innerHTML = document.getElementById("demo<?php echo $row5['orderID']; ?>").innerHTML;
                                        window.frames["print_frame<?php echo $row5['orderID']; ?>"].window.focus();
                                        window.frames["print_frame<?php echo $row5['orderID']; ?>"].window.print();
                                    }
                                </script>
                                <iframe name="print_frame<?php echo $row5['orderID']; ?>" width="0" height="0" frameborder="0" src="about:blank"></iframe>
                            </div>
                            <div id="demo<?php echo $row5['orderID']; ?>" class="collapse">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                                veniam,
                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                <table>
                                    <tr>
                                        <th>Productnummer</th>
                                        <th>Product</th>
                                        <th>Omschrijving</th>
                                        <th>Stuksprijs</th>
                                        <th>Aantal</th>
                                        <th>Totaalprijs</th>
                                    </tr>
                                    <?php
                                    //hier wordt de inhoud van order_line en product opgehaald, waar de orderID overeenkomt met de orderID van de gekozen order(de gekozen collapse), hierdoor krijg je alleen de producten uit de gekozen order te zien
                                    $orderID=$row5['orderID'];
                                    $sql6="SELECT * FROM order_line, product WHERE orderID='$orderID' and order_line.productID=product.productID";
                                    $result6=$conn->query($sql6);
                                    while($row6=mysqli_fetch_array($result6)){
                                        ?>
                                    <tr>
                                        <td><?php echo $row6['productID']; ?></td>
                                        <td><?php echo $row6['name']; ?></td>
                                        <td><?php echo $row6['description']; ?></td>
                                        <td>&euro;<?php echo $row6['price']; ?>,00</td>
                                        <td><?php echo $row6['quantity']; ?></td>
                                        <td>&euro;<?php echo $row6['price']*$row6['quantity']; ?>,00</td>
                                    </tr>
                                        <?php
                                    }
                                    ?>
                                </table>
<!--                                <button class="btn btn-success" onclick="myFunction()">Printen</button>-->
                            </div>
                            <?php
                        }
                    }else{
                        echo "Geen bestellingen gevonden.";
                    }
                    ?>

                </div>
                <div id="menu2" class="tab-pane fade">
                    <h2 class="text-center">Wachtwoord wijzigen</h2>
                    <form action="" method="post">
                        <input type="password" name="old_password" placeholder="Oud wachtwoord">
                        <input type="password" name="new_password1" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="Nieuw wachtwoord" required>
                        <input type="password" name="new_password2" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="Nieuw wachtwoord herhalen">
                        <input type="submit" name="change_password_btn" value="Wachtwoord wijzigen">
                    </form>
                    <?php
                    //hier worden eerst de waarden uit de form opgehaald, daarna wordt het wachtwoord uit de database gehaald die bij de ingelogde gebruikersnaam hoort, die wordt dmv Bcrypt vergeleken met het ingevoerde wachtwoord, daarna worden de 2 nieuwe ingevoerde wachtwoorden met elkaar vergeleken, als dit allemaal klopt wordt het nieuwe password gehashed en wordt de tabel user geupdate met het nieuwe wachtwoord.
                    if(isset($_POST['change_password_btn'])){
                        $old_password=mysqli_real_escape_string($conn, $_POST['old_password']);
                        $new_password1=mysqli_real_escape_string($conn, $_POST['new_password1']);
                        $new_password2=mysqli_real_escape_string($conn, $_POST['new_password2']);

                        $sql3="SELECT password FROM user WHERE username='$username'";
                        $result3=$conn->query($sql3);
                        if (mysqli_num_rows($result3) == 1) {
                            while ($row3 = mysqli_fetch_assoc($result3)) {
                                $dbpassword = $row['password'];
                            }
                            if ($crypt->verify($old_password, $dbpassword)) {
                                if ($new_password1 == $new_password2) {
                                    $hashed_password_new = $crypt->create($new_password2);

//                                    $sql4 = "UPDATE user SET password = '$hashed_password_new' WHERE username = '$username'";
//                                    $result4 = $conn->query($sql4);
//                                    if ($conn->query($sql4) === TRUE) {
//                                        echo "Uw wachtwoord is aangepast!";
//                                    } else {
//                                        echo "Error: " . $sql4 . "<br>" . $conn->error;
//                                    }
                                    $stmt=$conn->prepare("UPDATE user SET password=? WHERE username='$username'");
                                    $stmt->bind_param("s", $hashed_password_new);
                                    $stmt->execute();
                                    echo "Wachtwoord wijzigen gelukt.";
                                    if (!$stmt->execute()) {
                                        echo "Wachtwoord wijzigen mislukt.";
                                    }
                                } else {
                                    echo "Wachtwoorden komen niet overeen!";
                                }
                            } else {
                                echo "Verkeerd wachtwoord ingevoerd!";
                            }
                        }
                    }
                    ?>
                </div>
                <div id="menu3" class="tab-pane fade">
                    <h2 class="text-center">Berichten</h2>
                    <form action="" method="post">
                        <input type="text" name="subject" placeholder="Onderwerp">
                        <textarea name="message" placeholder="Bericht"></textarea>
                        <input type="submit" name="send_message" value="Bericht versturen" class="btn btn-primary">
                    </form>
                    <?php
                    //hier worden de, in de bovenstaande form ingevoerde, gegevens opgeslagen in de tabel message
                    if(isset($_POST['send_message'])) {
                        $subject=$_POST['subject'];
                        $message=$_POST['message'];
                        $timestamp=date('Y-m-d H:i:s');
                        $sqluserID="SELECT * FROM user WHERE username='$username'";
                        $resultuserID=$conn->query($sqluserID);
                        while($rowuserID=mysqli_fetch_array($resultuserID)){
                            $userID=$rowuserID['userID'];
                        }
//                        $sql8 = "INSERT INTO message (userID, timestamp, message, subject) VALUES ((SELECT userID FROM user WHERE username='$username'), '$timestamp', '$message', '$subject')";
//                        $result8=$conn->query($sql8);
//                        if($result8){
//                            echo "Bericht versturen gelukt.";
//                        }else{
//                            echo "Bericht versturen mislukt.";
//                        }
                        $stmt=$conn->prepare("INSERT INTO message(userID, timestamp, subject, message) VALUES (?, ?, ?, ?)");
                        $stmt->bind_param("isss", $userID, $timestamp, $subject, $message);
                        $stmt->execute();
                        echo "Bericht versturen gelukt.";
                        if(!$stmt->execute()){
                            echo "Bericht versturen mislukt.";
                        }
                    }?>
                    <?php
                    $sql7="SELECT * FROM message WHERE (SELECT username FROM user WHERE user.userID=message.userID)='$username'";
                    $result7=$conn->query($sql7);
                    while($row7=mysqli_fetch_array($result7)) {
                        ?>
                        <div class="btn btn-info col-xs-12" data-toggle="collapse"
                             data-target="#demo<?php echo $row7['messageID']; ?>"><?php echo $row7['subject']; ?>
                        </div>
                        <div id="demo<?php echo $row7['messageID']; ?>" class="collapse">
                            <i>Onderwerp</i><br>
                            <?php echo $row7['subject']; ?>
                            <br>
                            <i>Bericht</i><br>
                            <?php echo $row7['message']; ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}
include "./includes/footer.php";
?>
