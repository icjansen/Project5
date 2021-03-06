<?php
/**
 * Created by PhpStorm.
 * User: Iris
 * Date: 28-3-2018
 * Time: 15:19
 */

include "./includes/head.php";
include "./includes/navbar.php";
?>
    <div class="container">
        <h1 class="text-center"><i>Zoek producten</i></h1>
        <div class="col-xs-12 col-md-3 search_container">
            <input type="text" style="width: 90%; margin-left: 10px;" placeholder="Zoeken">
        </div>
        <div class="col-xs-12 col-md-9 search_results">
            <?php
            //hier worden alle producten uit de tabel product opgehaald, en wordt de data dmv een while-loop getoond
            $sql="SELECT * FROM product";
            $result=$conn->query($sql);
            while($row=mysqli_fetch_array($result)){
                ?>
                <div class="row product_list">
                    <div class="col-xs-4 col-md-2">
                        <img class="product_selection_images" src="images/<?php echo $row['image'];?>" alt="product_image">
                    </div>
                    <div class="col-xs-3 col-md-8 product_description">
                        <?php echo $row['name'];?>
                    </div>
                    <div class="col-xs-5 col-md-2">
                        <form action="product-info.php" method="get">
                            <input type="hidden" name="productID" value="<?php echo $row['productID'];?>">
                            <input type="submit" name="product_selection" value="Meer..." class="btn btn-info">
                        </form>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
<?php
include './includes/footer.php';
?>