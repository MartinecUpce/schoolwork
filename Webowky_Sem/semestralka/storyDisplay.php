<?php
/**
 * Created by PhpStorm.
 * User: Vojta
 * Date: 20/01/2019
 * Time: 19:12
 */
include 'elementals/header.php';
include 'Connection.php';




?><link rel="stylesheet" type="text/css" href="css/test1.css">
<link rel="stylesheet" type="text/css" href="../css/test2.css">
<link rel="stylesheet" type="text/css" href="../css/forms.css">

<main>

    <div class="center-wrapper">
        <div>
            <?php if (!empty($_GET['storyId'])){
                $conn = Connection::getPdoInstance();
                $id = $_GET['storyId'];
                $stmt = $conn->prepare("Select * from story where idStory = $id");
                $result = $stmt->execute();
                $result = $stmt ->fetch();
                $what = $result["storyName"];

                ?>
                <h1 align="center"><?php
                    echo $what?></h1>
                <h2>Summary</h2>
                <?php
                $conn = Connection::getPdoInstance();
                $stmt = $conn->prepare("Select storySummary from story where idStory = $id");
                $result = $stmt->execute();
                $result = $stmt ->fetch();
                $what = $result["storySummary"];
                echo $what;
                ?>
                <h2>List of sites</h2>
                <?php
                $stmt = $conn->prepare("Select stranka.jmeno,linkstorystra.linked from story join linkstorystra on story.idStory = linkstorystra.idStor join stranka on stranka.id_Stranka = linkstorystra.idStranky where idStory = $id");
                $stmt ->execute();
                $result = $stmt->fetchAll();
                foreach($result as $row){
                    ?>
                 <a href ="<?php echo $row["linked"]?>"><?php echo $row["jmeno"]?></a>
                <?php }
                ?>
                <h2>Assorted tags</h2>

                <?php
                $stmt = $conn->prepare("Select tag.tagName from story join tagstory on story.idStory = tagstory.fkStory join tag on tag.idTag = tagstory.fkTag where idStory = $id");
               $stmt ->execute();
            $result = $stmt->fetchAll();
            foreach($result as $row){
                ?>
                <?php echo $row["tagName"]?>.
           <?php }
                ?>

                <h2>Reviews</h2>
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
                $stmt = $conn->prepare("Select review.hodnoceni,review.idReview,review.content,u.userNick,review.timeCreated from story join review on story.idStory = review.fkStoryid join uzivatel u on review.fkUzivatelid = u.idUzivatel where idStory = $id");
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
                        <td><a href="delet.php?delid=<?php echo $row['idReview']?>&tablaName=review">Deletion</a></td>
                    <?php }?>

                    </tr>
                <?php }
                ?>
            </table>
            <?php
                 if (!empty($_SESSION["user_id"]) ) {  $review = "";?>

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


            <?php
                     //
                     if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["postReview"])) {





                             try{
                                 $choice = $_POST["select_hodnoceni"];
                                 $review = $_POST["reviewArea"];
                                 $uz = $_SESSION["user_id"];
                                 $conn = Connection::getPdoInstance();
                                 $idSt = $_GET["storyId"];

                                 $stmt = $conn->prepare("insert into review (fkStoryid,content,hodnoceni,fkUzivatelid)values('$id',:review,'$choice','$uz')");
                                 $stmt->bindParam(':review',$_POST["reviewArea"]);
                                 $stmt->execute();
                                 echo $id;
                                $stmt = $conn->prepare("select AVG(review.hodnoceni) from review where review.fkStoryid = $id ");
                                $stmt->execute();
                                $sum = $stmt->fetchColumn();
                                $stmt = $conn->prepare("update story set story.hodnoceni = $sum where idStory = $id");
                                 echo "<script type='text/javascript'>window.location.href = 'storyDisplay.php?storyId=$idSt';</script>";
                             }catch(PDOException $ex){
                                echo $ex;
                                 echo "<script type='text/javascript'>alert('You cannot post two reviews for the same story');</script>";
                             }


                     }

            }
            } else{?>
                <h1 align="center">You are not supposed to be here</h1>

            <?php }
            ?>
        </div>
    </div>
</main>
<?php
include 'elementals/footer.html';
?>
