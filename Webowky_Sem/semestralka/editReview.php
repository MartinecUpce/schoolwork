<?php
include "DeleteStory.php";
include 'elementals/header.php';
$conn = Connection::getPdoInstance();

if(empty($_GET["idRev"]) or empty($_GET["table"])){
    header("Location:"."about2.php");
    exit();
}

$idRev = $_GET["idRev"];
$table = $_GET["table"];

$stmt = $conn->prepare("select * from review where idReview = '$idRev'");
$stmt->execute();
$res = $stmt->fetch();
if($table == 'story'){
    $idVar = $res["fkStoryid"];

}else{
    $idVar = $res["fkAutorid"];
}


if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["cancel"])) {
    if($table == "story"){
        header("Location:"."storyDisplay.php?storyId=$idVar");
    }else{
        header("Location:"."authorDisplay.php?idAutoria=$idVar");
    }

}

if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["updateReview"])) {
try{
        $choice = $_POST["select_hodnoceni"];
        $review = $_POST["reviewArea"];

       if(!empty($review)) {
           $conn = Connection::getPdoInstance();
           //  $idSt = $_GET["idAutoria"];

           $stmt = $conn->prepare("update review set content = :review,hodnoceni= '$choice',timeEdited = CURRENT_TIMESTAMP where idReview = $idRev");
           $stmt->bindParam(':review', $_POST["reviewArea"]);
           $stmt->execute();

           DeleteStory::updateHodnoceni($idVar,$table);

           if($table == "story"){
               header("Location:"."storyDisplay.php?storyId=$idVar");
           }else{
               header("Location:"."authorDisplay.php?idAutoria=$idVar");
           }
       }
       else{
           echo "<script type='text/javascript'>alert('empty review unpostable');</script>";
       }
        //    echo "<script type='text/javascript'>window.location.href = 'authorDisplay.php?idAutoria=$var';</script>";
    }catch(PDOException $ex){
           echo $ex;

        echo "<script type='text/javascript'>alert('Some unknown problem is going on in here');</script>";
    }


}




?>
    <main>
        <link rel="stylesheet" type="text/css" href="css/test1.css">
        <link rel="stylesheet" type="text/css" href="../css/test2.css">
        <div class="center-wrapper">
            <div>
                <?php echo "<h2>Review edit</h2>" ?>
                <form action="" method="post">


                    <label>Make Review:</label>  <textarea name="reviewArea" rows="5" cols="40" maxlength="1000"><?php echo $res["content"] ?> </textarea>
                    <br>

                    <select name="select_hodnoceni">


                        <?php
                        for ($i = 0; $i < 6; $i++) {

                                ?>
                                <option <?php if ($i == $res["hodnoceni"] ) echo 'selected' ; ?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                <?php
                           // }
                        }?>




                    </select>
                    <input type="submit" name="updateReview" value="Update review"/>
                    <input type="submit" name="cancel" value="Cancel"/>

                </form>
                <br>
            </div>
        </div>
    </main>
<?php
include 'elementals/footer.html';
/*
 *     for ($i = 0; $i < 6; $i++) {
                            if($i == $res["hodnoceni"] ){
                            ?>
                            <option value = "<?php $i?>", selected="selected"> <?php echo $i?></option>
                            <?php}
                            else{
                                ?>
                                <option value = "<?php $i?>"> <?php echo $i?></option>
                                <?php
                            }
                        }
<option value = "0" selected="selected">0</option>
                        <option value = "1">1</option>
                        <option value = "2">2</option>
                        <option value = "3">3</option>
                        <option value = "4">4</option>
                        <option value = "5">5</option>


 */
?>