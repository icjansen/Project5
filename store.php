<?php
include "head.php";
include "navbar.php";

if(!isset($_SESSION['cart'])) {
    $array = array();
    $_SESSION['cart'] = $array;
}

$sql="SELECT * FROM product";//hiermee wordt alles uit de tabel product geselecteerd, en dmv een while-loop getoond.
$result=$conn->query($sql);
while($row=mysqli_fetch_array($result)){
    ?>
    <div class="col-xs-3">
        <?php echo $row['name'];?>
        <form action="" method="post">
            <input type="hidden" name="productID" value="<?php echo $row['productID'];?>"><!--de productID wordt in een hidden input meegegeven, zodat aan de hand hiervan een product in de winkelwagen gedaan kan worden.-->
            <input type="submit" name="add_to_cart" value="Toevoegen" class="btn btn-primary">
        </form>
    </div>
    <?php
}
if(isset($_POST['add_to_cart'])){//de inhoud van het formulier wordt opgehaald, en dmv array_push wordt de productID toegevoegd aan het array die in de sessie wordt opgeslagen
    $array=$_SESSION['cart'];
    $productID=$_POST['productID'];
    array_push($array, $productID);
    $_SESSION['cart']=$array;
    print_r($_SESSION['cart']);
}
