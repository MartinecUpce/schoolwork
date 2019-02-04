<?php
/**
 * Created by PhpStorm.
 * User: Vojta
 * Date: 20/01/2019
 * Time: 19:12
 */
include 'elementals/header.php';
include 'DeleteStory.php';




?>
<link rel="stylesheet" type="text/css" href="css/test1.css">
<link rel="stylesheet" type="text/css" href="/css/test2.css">
<link rel="stylesheet" type="text/css" href="/css/forms.css">
<?php
if(empty($_GET["storyId"])){
    header("Location:"."stories.php");
    exit();
}
$id = $_GET['storyId'];

if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['deletion'])){
    $someId = $_POST['id_Review'];
    $table = "story";
    DeleteStory::deleteReview2($someId,$id,$table);
}
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['editing'])){
    $someId = $_POST['id_Review'];
    header("Location:"."editReview.php?idRev=$someId&table=story");
}


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

        $stmt = $conn->prepare("select AVG(1.0 * review.hodnoceni ) from review where review.fkStoryid = $id ");
        $stmt->execute();
        $sum = $stmt->fetchColumn();
        $stmt = $conn->prepare("update story set story.hodnoceni = $sum where idStory = $id");
        $stmt->execute();
        // echo "<script type='text/javascript'>window.location.href = 'storyDisplay.php?storyId=$idSt';</script>";
    }catch(PDOException $ex){
        //  echo $ex;
        echo "<script type='text/javascript'>alert('You cannot post two reviews for the same story');</script>";
    }


}

?>
<main>

    <div class="center-wrapper">
        <div>
            <?php
                $conn = Connection::getPdoInstance();

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


                <div class="one">
                <?php
                $stmt = $conn->prepare("Select review.hodnoceni,review.idReview,review.content,u.userNick, u.idUzivatel,review.timeCreated,review.timeEdited from story join review on story.idStory = review.fkStoryid join uzivatel u on review.fkUzivatelid = u.idUzivatel where idStory = $id");
                $stmt ->execute();
                $result = $stmt->fetchAll();
                foreach($result as $row) {
                    ?>
                    <div class="two">
                    <h3><?php echo $row["userNick"] ?></h3>
                        <h4>Rated as <?php echo $row["hodnoceni"] ?> out of 5</h4>
                    <p class="three"> <?php echo $row["content"] ?></p>

                  <p align="right">  <?php
                    if (!empty($row["timeEdited"])) {
                        echo $row["timeEdited"];
                    } else {
                        echo $row["timeCreated"];
                    }

                    if (!empty($_SESSION["user_id"]) and (($_SESSION["logged"] == 'admin') or ($row["idUzivatel"] == $_SESSION["user_id"]))) {
                        ?>



                        <form action="" method="post">
                            <input type="hidden" name="id_Review" value="<?= $row['idReview'] ?>"/>
                            <input align="right" type="submit" name="deletion" value="Delete"/>
                            <?php
                            if ($row["idUzivatel"] == $_SESSION["user_id"]) {
                                ?>
                                <input align="right" type="submit" name="editing" value="Edit"/>
                                <?php
                            }
                            ?>
                        </form>
                        </p>
                    <?php
                    }?>
                    </div>
                    <?php
                }
                $review = "";
                ?>
                </div>

<br>
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
            <br>
            <br>
            <br>
        </div>
    </div>
</main>
<?php
include 'elementals/footer.html';
?>