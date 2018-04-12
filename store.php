<?php
include "./includes/head.php";
include "./includes/navbar.php";

if(!isset($_SESSION['cart'])) {
    $array = array(array());
    $_SESSION['cart'] = $array;
}

$sql="SELECT * FROM product";//hiermee wordt alles uit de tabel product geselecteerd, en dmv een while-loop getoond.
$result=$conn->query($sql);
while($row=mysqli_fetch_array($result)){
    ?>
    <div class="col-xs-12 col-md-3 store_products">
        <h3><?php echo $row['name'];?></h3>
        <img src="images/<?php echo $row['image'];?>" alt="product_image" class="store_product_images">
        <form action="" method="post">
            <input type="hidden" name="productID" value="<?php echo $row['productID'];?>"><!--de productID wordt in een hidden input meegegeven, zodat aan de hand hiervan een product in de winkelwagen gedaan kan worden.-->
            <label>Selecteer aantal:
                <select name="product_quantity">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                    <option>7</option>
                    <option>8</option>
                    <option>9</option>
                    <option>10</option>
                </select>
            </label>
            <input type="submit" name="add_to_cart" value="Toevoegen" class="btn btn-primary">
        </form>
    </div>
    <?php
}
if(isset($_POST['add_to_cart'])){//de inhoud van het formulier wordt opgehaald, en dmv array_push wordt de productID toegevoegd aan het array die in de sessie wordt opgeslagen
    $array=$_SESSION['cart'];
    $productID=$_POST['productID'];
    $quantity=$_POST['product_quantity'];
//    array_push($array, $productID);
    $productarray=array($productID, $quantity);
    array_push($array, $productarray);
//    print_r($productarray);
    $_SESSION['cart']=$array;
    echo "<pre>";
    print_r($_SESSION['cart']);
    echo "</pre>";
//    print_r($_SESSION['cart']);
}

//include './includes/footer.php';