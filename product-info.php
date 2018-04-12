<?php
/**
 * Created by PhpStorm.
 * User: Iris
 * Date: 28-3-2018
 * Time: 15:19
 */

include "./includes/head.php";
include "./includes/navbar.php";
if(isset($_SESSION['username'])) { $username=$_SESSION['username']; }
if(isset($_GET['product_selection'])){
    $productID=$_GET['productID'];
//    echo $productID;
}
$sql="SELECT * FROM product WHERE productID='$productID'";
$result=$conn->query($sql);
while($row=mysqli_fetch_array($result)){
?>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 50%;
            margin-left: 0;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>

    <div class="container">
        <div class="row" style="height: 200px;">
            <div class="col-xs-7">
                <img class="product_images" src="images/<?php echo $row['image'];?>" alt="product">
            </div>
            <div class="col-xs-5">
                <p style="height: 200px; overflow: scroll;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam in elementum tellus, sed consectetur felis. Vivamus consectetur vehicula augue non ornare. Mauris pellentesque erat quis leo varius condimentum. Pellentesque lacinia nisl in lorem posuere congue. Mauris quam est, varius nec lorem vel, posuere finibus orci. Nam mi tellus, vestibulum quis dictum eu, malesuada eu ex. Nam non enim vitae lectus sodales lacinia.</p>
            </div>
        </div>
        <div class="row">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">Algemeen</a></li>
                <li><a data-toggle="tab" href="#menu1">Specificaties</a></li>
                <li><a data-toggle="tab" href="#menu2">Reviews</a></li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <h3>Algemeen</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam in elementum tellus, sed consectetur felis. Vivamus consectetur vehicula augue non ornare. Mauris pellentesque erat quis leo varius condimentum. Pellentesque lacinia nisl in lorem posuere congue. Mauris quam est, varius nec lorem vel, posuere finibus orci. Nam mi tellus, vestibulum quis dictum eu, malesuada eu ex. Nam non enim vitae lectus sodales lacinia.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam in elementum tellus, sed consectetur felis. Vivamus consectetur vehicula augue non ornare. Mauris pellentesque erat quis leo varius condimentum. Pellentesque lacinia nisl in lorem posuere congue. Mauris quam est, varius nec lorem vel, posuere finibus orci. Nam mi tellus, vestibulum quis dictum eu, malesuada eu ex. Nam non enim vitae lectus sodales lacinia.</p>
                </div>
                <div id="menu1" class="tab-pane fade" style="overflow: scroll; overflow-x: hidden;">
                    <h3>Specificaties</h3>
                    <table>
                        <tr>
                            <th>Company</th>
                            <th>Contact</th>
                        </tr>
                        <tr>
                            <td>Alfreds Futterkiste</td>
                            <td>Maria Anders</td>
                        </tr>
                        <tr>
                            <td>Centro comercial Moctezuma</td>
                            <td>Francisco Chang</td>
                        </tr>
                        <tr>
                            <td>Ernst Handel</td>
                            <td>Roland Mendel</td>
                        </tr>
                        <tr>
                            <td>Island Trading</td>
                            <td>Helen Bennett</td>
                        </tr>
                        <tr>
                            <td>Laughing Bacchus Winecellars</td>
                            <td>Yoshi Tannamuri</td>
                        </tr>
                        <tr>
                            <td>Magazzini Alimentari Riuniti</td>
                            <td>Giovanni Rovelli</td>
                        </tr>
                    </table>

                </div>
                <div id="menu2" class="tab-pane fade">
                    <h3>Reviews</h3>
                    <a class="btn btn-primary upload_button" href="#upload_anchor">Klik hier om je eigen review te schrijven!</a>
                    <?php
                    $sql3="SELECT * FROM review INNER JOIN user ON review.userID=user.userID";
                    $result3=$conn->query($sql3);
                    while($row3=mysqli_fetch_array($result3)){
                        ?>
                        <div class="panel panel-default">
                            <div class="panel-heading"><?php echo $row3['review_subject'];?>, cijfer: <?php echo $row3['grade'];?></div>
                            <div class="panel-body"><?php echo $row3['review_message'];?></div>
                            <div class="panel-footer"><i>Geschreven door: <?php echo $row3['username'];?> op <?php echo $row3['review_timestamp'];?></i></div>
                        </div>
                        <?php
                    }
                    ?>


                    <?php if(isset($_SESSION['username'])){?>
                        <form id="upload_anchor" action="" method="post">
                            <input type="text" name="subject" placeholder="Voer een titel in">
                            Bericht<textarea name="message" style="width: 100%; height: 100px;"></textarea>
                            <input type="number" name="grade" placeholder="Voer een cijfer in">
                            <input type="submit" name="submit_review" value="Review versturen" class="btn btn-success">
                        </form>
                        <?php
                        if(isset($_POST['submit_review'])){
                            $subject=$_POST['subject'];
                            $message=$_POST['message'];
                            $grade=$_POST['grade'];
                            $timestamp=date('Y-m-d H:i:s');
                            $sql2="INSERT INTO review (productID, userID, grade, review_message, review_subject, review_timestamp) VALUES ('$productID', 
                    (SELECT userID FROM user WHERE username='$username'), '$grade', '$message', '$subject', '$timestamp')";
                            $result2=$conn->query($sql2);
                            if($result2){
                                echo "Review plaatsen gelukt.";
                            }else{
                                echo "Review plaatsen mislukt.";
                            }
                        }
                    } else{
                        ?>
                        <h2><a id="upload_anchor" href="login.php">Log in</a> om een review te kunnen schrijven.</h2>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

<?php
include './includes/footer.php';
