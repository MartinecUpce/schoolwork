<?php
/**
 * Created by PhpStorm.
 * User: Vojta
 * Date: 03/02/2019
 * Time: 19:27
 */

include 'elementals/header.php';
include 'DeleteStory.php';

$conn = Connection::getPdoInstance();
if($_SESSION["logged"] != 'admin'){
    header("Location:"."about2.php");
    exit();
}
if(isset($_POST["addTag"])){
    if(empty($_POST["newTag"])){
        echo "<script type='text/javascript'>alert('Cannot have empty name of tag');</script>";
    }else{
        try{
            $stmt = $conn->prepare("insert into tag (tagName) value (:tag)");
            $stmt->bindParam(":tag",$_POST["newTag"]);
            $stmt->execute();
        }catch(PDOException $ex){
            echo "<script type='text/javascript'>alert('Such a tag already exists');</script>";
        }
    }
}
if(isset($_POST["removeTag"])){
 if (!isset($_POST['remove_tag_select'])) {
    echo "<script type='text/javascript'>alert('Improperly Selected boxes');</script>";
}else{
        try{
            $choice_tag = $_POST['remove_tag_select'];
            $stmt = $conn->prepare("delete from tagstory where fkTag = $choice_tag");
            $stmt->execute();
            $stmt = $conn->prepare("delete from tag where idTag = $choice_tag");

            $stmt->execute();
        }catch(PDOException $ex){
            echo "<script type='text/javascript'>alert('Cannot delete for some reason');</script>";
        }
    }
}
$stmt = $conn->prepare("select * from tag");
$stmt->execute();
$tagRes = $stmt->fetchAll();


?>
    <main>
        <link rel="stylesheet" type="text/css" href="css/test1.css">
        <link rel="stylesheet" type="text/css" href="css/test2.css">
        <div class="center-wrapper">
            <?php

            ?>
            <div>
                <h2 align="center">Manage Tags</h2>
                <p>
                    <form action="" method="post">

                    <input type="text" name="newTag" placeholder="new tag">

                    <input type="submit" name="addTag" value="Add tag">
                </form>
                </p>
                <p>
                <form action="" method="post">

                    <label>Genre tag of story: </label><select name="remove_tag_select">
                        <?php
                        $f = 0;
                        foreach($tagRes as $row1) { if(f == 0){?>

                            <option value="<?=$row1["idTag"];?>",selected="selected"><?=$row1["tagName"];?></option>



                            <?php $f = 1; }else {
                            ?>

                            <option value="<?=$row1["idTag"];?>"><?=$row1["tagName"];?></option>



                            <?php

                            }
                        }
                        ?>
                    </select><br>

                    <input type="submit" name="removeTag" value="remove tag">
                </form>
                </p>
            </div>
        </div>
    </main>
<br>
<br>
<br>
<br>
<?php
include 'elementals/footer.html';
?>