<?php

include_once "DeleteStory.php";
include 'elementals/header.php';
if (empty($_GET['idAutoria']) == false) {
    $var = $_GET['idAutoria'];
    $conn = Connection::getPdoInstance();
    $stmt = $conn->prepare("select nick from autor where idAutor = $var");
    $stmt->execute();
    $var2 = $stmt->fetchColumn();
}

?><link rel="stylesheet" type="text/css" href="css/test1.css">
    <link rel="stylesheet" type="text/css" href="../css/test2.css">
    <main>

        <div class="center-wrapper">
            <div>
                <?php if (empty($_GET['idAutoria']) == false){ ?>
                <h1 align="center"><?php
                    echo $var2;
                    ?></h1>
                <h2>List of sites</h2>
                    <p>
                        <?php
                        $stmt = $conn->prepare("select linkautstr.linked,stranka.jmeno from linkautstr join stranka on stranka.id_Stranka = linkautstr.idStranky where linkautstr.idAutora = $var ");
                        $stmt->execute();
                        $res = $stmt->fetchAll();
                        foreach($res as $row){
                            ?>
                            <a href="<?php echo $row["linked"] ?>">
                                <?php echo $row['jmeno']?> ,
                            </a>
                            <?php
                        }
                        ?>

                    </p>
                <h2>List of fics</h2>
                    <p>
                        <?php
                            $stmt = $conn->prepare("select * from story where fk_Autorid = $var ");
                            $stmt->execute();
                            $res = $stmt->fetchAll();
                            foreach($res as $row){
                                ?>
                                <a href="./storyDisplay.php?storyId=<?php echo $row['idStory']?>">
                                    <?php echo $row['storyName']?> ,
                                </a>
                                <?php
                            }
                        ?>
                    </p>

                    <table>
                        <tr>
                            <th>User</th>
                            <th>Review</th>
                            <th>Date</th>
                            <th>hodnoceni</th>
                            <?php if (!empty($_SESSION["user_id"]) and $_SESSION["logged"] == "admin") { ?>
                                <th> Deletion </th>
                            <?php }?>

                        </tr>
                        <?php
                        $stmt = $conn->prepare("Select review.hodnoceni,review.idReview,review.content,u.userNick,review.timeCreated from autor join review on autor.idAutor = review.fkAutorid join uzivatel u on review.fkUzivatelid = u.idUzivatel where autor.idAutor = $var");
                        $stmt ->execute();
                        $result = $stmt->fetchAll();
                        foreach($result as $row){
                            ?><tr>
                            <td> <?php echo $row["userNick"]?></td>
                            <td> <?php  $str = $row["content"] ;
                                echo wordwrap($str,50,"<br>\n");?></td>
                            <td> <?php echo $row["timeCreated"]?></td>
                            <td><?php echo $row["hodnoceni"]?></td>
                            <?php if (!empty($_SESSION["user_id"]) and $_SESSION["logged"] == 'admin') { ?>
                                <td>
                                    <form action= "" method="post">
                                        <input type="hidden" name="id_Review" value="<?= $row['idReview'] ?>" />
                                        <input type="submit" name="deletion" value="Delete" />
                                    </form>
                                    <?php

                                    ?>
                                </td>
                            <?php }?>

                            </tr>
                        <?php }
                        if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['deletion'])){
                            $someId = $_POST['id_Review'];
                            DeleteStory::deleteReview($someId,$var,"autor");//($row['idStory']);
                        }
                        ?>
                    </table>



                <h2>Reviews</h2>
                  <?php  if (!empty($_SESSION["user_id"]) ) {  $review = "";?>

                    <form action="" method="post">


                        <label>Review:</label>  <textarea name="reviewArea" rows="5" cols="40" maxlength="1000"><?php $review ?></textarea>
                        <br>
                        <select name="select_hodnoceni">
                            <option value = "0" selected="selected">0</option>
                            <option value = "1">1</option>
                            <option value = "2">2</option>
                            <option value = "3">3</option>
                            <option value = "4">4</option>
                            <option value = "5">5</option>
                        </select>
                        <input type="submit" name="postReview" value="post review"/>

                    </form>
                    <br>
                <?php }

                    if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["postReview"])) {





                        try{
                            $choice = $_POST["select_hodnoceni"];
                            $review = $_POST["reviewArea"];
                            $uz = $_SESSION["user_id"];
                            $conn = Connection::getPdoInstance();
                            $idSt = $_GET["storyId"];

                            $stmt = $conn->prepare("insert into review (fkAutorid,content,hodnoceni,fkUzivatelid)values('$var',:review,'$choice','$uz')");
                            $stmt->bindParam(':review',$_POST["reviewArea"]);
                            $stmt->execute();
                            echo $id;
                            $stmt = $conn->prepare("select AVG(review.hodnoceni) from review where review.fkAutorid = $var ");
                            $stmt->execute();
                            $sum = $stmt->fetchColumn();
                            $stmt = $conn->prepare("update autor set autor.hodnoceni = $sum where idAutor = $var");
                            echo "<script type='text/javascript'>window.location.href = 'authorDisplay.php?idAutoria=$var';</script>";
                        }catch(PDOException $ex){
                            echo $ex;
                            echo "<script type='text/javascript'>alert('You cannot post two reviews for the same story');</script>";
                        }


                    }

                }

                else{

                    ?>

                    <h1 align="center">You are not supposed to be here</h1>

                <?php }?>
            </div>
        </div>
    </main>
<?php
include 'elementals/footer.html';
?>