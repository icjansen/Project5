<?php
/**
 * Created by PhpStorm.
 * User: Iris
 * Date: 10-4-2018
 * Time: 14:44
 */
include "./includes/head.php";
include "./includes/navbar.php";
$username=$_SESSION['username'];

if(!isset($_SESSION['cart'])) {
    $array = array();
    $_SESSION['cart'] = $array;
}
//print_r($_SESSION['cart']);

$array=$_SESSION['cart'];

//print_r($array);
echo "<pre>";
print_r($array);
echo "</pre>";

//met foreach elk product, query per product

//wanneer op bestellen wordt geklikt, nieuwe order aanmaken met besteltijd en gekozen afleverdatum
if(isset($_POST['confirm_order'])) {
    $order_date = date('Y-m-d H:i:s');
    $delivery_date = "2018-04-19";
//$delivery_date=$_POST['delivery_date'];
    $quantity = 1;
//$quantity=$_POST['quantity'];

    $stmt = $conn->prepare("INSERT INTO orders (userID, order_date, delivery_date) VALUES ((SELECT userID FROM user WHERE username='$username'), ?, ?)");
    $stmt->bind_param("ss", $order_date, $delivery_date);

    if ($stmt->execute()) {
//  orderID die hierboven is gemaakt ophalen met de daarboven aangegeven variabelen
        $sql = "SELECT * FROM orders WHERE userID=(SELECT userID FROM user WHERE username='$username') AND delivery_date='$delivery_date'";
        $result = $conn->query($sql);
        while ($row = mysqli_fetch_array($result)) {
            $orderID = $row['orderID'];
        }
    }
    $stmt->close();

    foreach ($array as $arrayproduct) {
        $productID = $arrayproduct[0];
        $quantity = $arrayproduct[1];
        //$productID = $arrayproduct;

//de hierboven opgehaalde orderID met de daarboven aangegeven productID en quantity versturen naar de tabel order_line, per product in de sessie (met foreach)
        $stmt = $conn->prepare("INSERT INTO order_line (orderID, productID, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $orderID, $productID, $quantity);
        $stmt->execute();
        $stmt->close();
        $array = array();
        $_SESSION['cart'] = $array;
    }
}
//als de sessie(winkelwagentje) NIET leeg is, dan wordt de button "bestelling afronden" getoond; wanneer de sessie wel leeg is, wordt alleen de tekst getoond
if($_SESSION['cart'] != null){
    ?>
    <div class="container">
        <form action="" method="post">
            <input type="submit" name="confirm_order" value="Bestelling afronden" class="btn btn-success">
        </form>
    </div>
    <?php
}else{
    echo "Selecteer eerst een product om te kunnen bestellen.";
}
?>