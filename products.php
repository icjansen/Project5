<?php
/**
 * Created by PhpStorm.
 * User: Iris
 * Date: 28-3-2018
 * Time: 15:19
 */

include "head.php";
include "navbar.php";
$username=$_SESSION['username'];
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
    <?php $product="laptop"; ?>
    <div class="row">
        <div class="col-xs-7">
            <img class="product_images" src="ASUS-laptops.png" alt="product">
        </div>
        <div class="col-xs-5">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam in elementum tellus, sed consectetur felis. Vivamus consectetur vehicula augue non ornare. Mauris pellentesque erat quis leo varius condimentum. Pellentesque lacinia nisl in lorem posuere congue. Mauris quam est, varius nec lorem vel, posuere finibus orci. Nam mi tellus, vestibulum quis dictum eu, malesuada eu ex. Nam non enim vitae lectus sodales lacinia.</p>
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
                <form action="" method="post">
                    <input type="text" name="subject" placeholder="Voer een titel in">
                    Bericht<textarea name="message" style="width: 50%; height: 100px;"></textarea>
                    <input type="number" name="grade" placeholder="Voer een cijfer in">
                    <input type="submit" name="submit_review" value="Review versturen">
                </form>
                <?php
                if(isset($_POST['submit_review'])){
                    $subject=$_POST['subject'];
                    $message=$_POST['message'];
                    $grade=$_POST['grade'];
                    $timestamp=date('Y-m-d H:i:s');
                    $sql="INSERT INTO review (productID, userID, grade, review_message, review_subject, review_timestamp) VALUES ((SELECT productID from product WHERE name='$product'), 
                    (SELECT userID from user WHERE username='$username'), '$grade', '$message', '$subject', '$timestamp')";
                    $result=$conn->query($sql);
                    if($result){
                        echo "Review plaatsen gelukt.";
                    }else{
                        echo "Review plaatsen mislukt.";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
include 'footer.php';
