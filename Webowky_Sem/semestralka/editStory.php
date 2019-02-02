<?php
/**
 * Created by PhpStorm.
 * User: Vojta
 * Date: 02/02/2019
 * Time: 14:55
 */



include 'elementals/header.php';
include 'DeleteStory.php';
if(empty($_GET["idStory"])) {
    header("location:" ."stories.php");
    exit();
}
$varId = $_GET["idStory"];
$conn = Connection::getPdoInstance();
$stmt = $conn->prepare("select * from story where idStory =$varId");
$stmt->execute();
$res = $stmt->fetch();
$varIdCurrA = $res["fk_Autorid"];
$stmt = $conn->prepare("select fkTag from tagstory where fkStory = $varId");
$stmt->execute();
$tags = $stmt->fetch();
if(isset($_POST["cancel"])){
    header("Location:" . "stories.php");
    exit();

}


/*$stmt = $conn->prepare("select linked from linkstorystra where idStor =$varId");
$stmt->execute();
$link = $stmt->fetchColumn();*/
?>
    <main>
        <link rel="stylesheet" type="text/css" href="css/test1.css">
        <link rel="stylesheet" type="text/css" href="../css/test2.css">
        <div class="center-wrapper">
            <div>
                <h2 align="center"></h2>
                <?php if (!empty($_SESSION["user_id"])) {

                    $name = $res["storyName"];
                    $summary = $res["storySummary"];
                    $link = "";
                    $conn = Connection::getPdoInstance();
                    $stmt1 = $conn->prepare("Select * from tag");
                    $result1 = $stmt1->execute();
                    $result1 = $stmt1->fetchAll();
                    ?>


                    <?php
                }
                ?>
                <form action="" method="post">

                        <label>Change tag: </label><select name="select_create_tag">
                        <?php

                        foreach($result1 as $row1) { ?>

                            <option <?php if($row1["idTag"] == $tags) {echo 'selected'; }?> value="<?=$row1["idTag"];?>"><?=$row1["tagName"];?></option>



                            <?php
                            ?>


                            <?php
                        }?>
                    </select>
                    <input type="submit" name="changeTag" value="Change Tag"/>
                    <br>
                </form>
                <form action="" method="post">

                    <label>Change to some other author </label>
                    <select name="select_create_author">
                        <?php
                        $conn = Connection::getPdoInstance();
                        $stmt1 = $conn->prepare("Select * from autor");
                        $result1 = $stmt1->execute();
                        $result1 = $stmt1 ->fetchAll();

                        foreach($result1 as $row1) { ?>

                            <option <?php if($row1["idAutor"] == $varIdCurrA) {echo 'selected';}?>value="<?=$row1["idAutor"];?>"><?=$row1["nick"];?></option>
                            <?php


                        }
                        ?>
                    </select><br>
                    <input type="submit" name="changeAuthor" value="Change Author"/>
                </form>


                   <br>


                <form action="" method="post">

                    <label>Change Name: </label><input type="text" name="name" value="<?php echo $name; ?>">

                    <br>
                    <input type="submit" name="changeName" value="change name"/>
                </form>
                <br>
                <form action="" method ="post">
                    <label>Change Summary:</label>  <textarea name="summary" rows="5" cols="40" maxlength="1000"><?php echo $summary; ?></textarea>

                    <br>
                    <input type="submit" name="changeSummary" value="Change summary"/>
                </form>
                <br>
                <form action ="" method="post">
                    <label>Select site for link: </label>
                    <select name="select_add_site">
                        <?php
                        $conn = Connection::getPdoInstance();
                        $stmt1 = $conn->prepare("Select * from stranka");
                        $result1 = $stmt1->execute();
                        $result1 = $stmt1 ->fetchAll();
                        $p = 0;
                        foreach($result1 as $row1) { if($p ==0){?>

                            <option value="<?=$row1["id_Stranka"];?>", selected="selected"><?=$row1["jmeno"];?></option>
                            <?php $p = 1;  }else {
                            ?>

                            <option value="<?=$row1["id_Stranka"];?>"><?=$row1["jmeno"];?></option>
                            <?php
                        }}
                        ?>
                    </select>

                    <label>Add Link: </label><input type="text" name="linkAdd" value="<?php echo $link; ?>">

                    <br>

                    <input type="submit" name="addLink" value="Add link"/>


                </form>


                <form action ="" method="post">
                    <label>Remove existing link: </label>
                    <select name="select_remove_site">
                        <?php
                        $conn = Connection::getPdoInstance();
                        $stmt1 = $conn->prepare("Select stranka.id_Stranka, stranka.jmeno from stranka join linkstorystra on stranka.id_Stranka = linkstorystra.idStranky where linkstorystra.idStor = $varId");
                        $result1 = $stmt1->execute();
                        $result1 = $stmt1 ->fetchAll();
                        $p = 0;
                        foreach($result1 as $row1) { if(p ==0){?>

                            <option value="<?=$row1["id_Stranka"];?>", selected="selected"><?=$row1["jmeno"];?></option>
                            <?php $p = 1;  }else {
                            ?>

                            <option value="<?=$row1["id_Stranka"];?>"><?=$row1["jmeno"];?></option>
                            <?php
                        }}
                        ?>
                    </select>



                    <br>

                    <input type="submit" name="removeLink" value="Remove link"/>
                    <input type="submit" name="cancel" value="Leave"/>


                </form>




                <br>
                <br>
                <br>
                <br>
                <?php
                if(isset($_POST["changeTag"])){
                    try {
                        $choiceTag = $_POST['select_create_tag'];
                        $stmt = $conn->prepare("update tagstory set tagstory.fkTag = $choiceTag where fkStory = $varId");
                        $stmt->execute();
                    }catch(PDOException $ex){
                        echo $ex;
                        echo "<script type='text/javascript'>alert('Story is already under this tag');</script>";
                    }

                }
                if(isset($_POST["changeAuthor"])){
                    try{
                        $choiceAuthor = $_POST["select_create_author"];
                        $stmt = $conn->prepare("update story set story.fk_Autorid = $choiceAuthor where idStory = $varId");
                        $stmt->execute();
                        DeleteStory::updateHodnoceni($choiceAuthor,"Author");
                    }catch(PDOException $ex){
                        echo $ex;
                        echo "<script type='text/javascript'>alert('That author already has story like that');</script>";
                    }
                }
                if(isset($_POST["changeName"])){
                    if(empty($_POST["name"])){
                        echo "<script type='text/javascript'>alert('Cannot have empty name');</script>";
                    }else{
                        try{
                            // $namen = $_POST["name"];
                            $stmt = $conn->prepare("update story set story.storyName = :name where idStory = $varId");
                            $stmt->bindParam(':name', $_POST['name']);
                            $stmt->execute();
                        }catch(PDOException $ex){
                            echo $ex;
                            echo "<script type='text/javascript'>alert('That author already has story with such name');</script>";
                        }
                    }

                }
                if(isset($_POST["changeSummary"])){
                    if(empty($_POST["summary"])){
                        echo "<script type='text/javascript'>alert('Cannot have entirely empty summary');</script>";
                    }else{
                        try{
                            // $namen = $_POST["name"];
                            $stmt = $conn->prepare("update story set story.storySummary = :summary where idStory = $varId");
                            $stmt->bindParam(':summary', $_POST['summary']);
                            $stmt->execute();
                        }catch(PDOException $ex){
                            echo $ex;
                            echo "<script type='text/javascript'>alert('bullshit');</script>";
                        }
                    }

                }
                if(isset($_POST["addLink"])){
                    if(empty($_POST["linkAdd"])){
                        echo "<script type='text/javascript'>alert('Cannot have entirely empty link');</script>";
                    }
                    else{
                        try{
                            $choiceLinkAdd = $_POST['select_add_site'];
                            $stmt1 = $conn->prepare("insert into linkstorystra(idStranky,idStor,linked) values('$choiceLink','$varId',:link)" );
                            $stmt1->bindParam(':link', $_POST['linkAdd']);
                            $stmt1->execute();
                        }catch(PDOException $ex){
                            echo $ex;
                            echo "<script type='text/javascript'>alert('Cannot have two links to any, even default site');</script>";
                        }
                    }

                }
                if(isset($_POST["removeLink"])){


                    try{
                        $choiceLink = $_POST['select_remove_site'];
                        $stmt1 = $conn->prepare("delete from linkstorystra where idStranky = '$choiceLink' and idStor = $varId");

                        $stmt1->execute();
                    }catch(PDOException $ex){
                        echo $ex;
                        echo "<script type='text/javascript'>alert('Cannot Delete for some reason');</script>";
                    }


                }
                if(isset($_POST["cancel"])){
                    echo "<script type='text/javascript'>window.location.href = 'stories.php';</script>";
                    exit();

                }
                 ?>
            </div>
        </div>
    </main>
<?php
include 'elementals/footer.html';
?>