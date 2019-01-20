<?php
/**
 * Created by PhpStorm.
 * User: Vojta
 * Date: 07/01/2019
 * Time: 18:17
 */
include 'elementals/header.php';
include 'Connection.php'

?>
    <main>
        <link rel="stylesheet" type="text/css" href="css/test1.css">
        <link rel="stylesheet" type="text/css" href="../css/test2.css">
        <div class="center-wrapper">
            <div>
                <h2 align="center"></h2>
                <?php if (!empty($_SESSION["user_id"])) {

                    $name = "";
                    $summary = "";
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
                    <label>Genre tag of story: </label><select name="select_create_tag">
                        <?php
                        $f = 0;
                        foreach($result1 as $row1) { if(f == 0){?>

                            <option value="<?=$row1["idTag"];?>",selected="selected"><?=$row1["tagName"];?></option>



                            <?php $f = 1; }else {
                            ?>

                            <option value="<?=$row1["idTag"];?>"><?=$row1["tagName"];?></option>



                            <?php

                        }
                        }
                        ?>
                    </select><br>
                    <label>Who wrote it: </label>
                    <select name="select_create_author">
                        <?php
                        $conn = Connection::getPdoInstance();
                        $stmt1 = $conn->prepare("Select * from autor");
                        $result1 = $stmt1->execute();
                        $result1 = $stmt1 ->fetchAll();
                        $c = 0;
                        foreach($result1 as $row1) { if (c== 0){?>

                            <option value="<?=$row1["idAutor"];?>",selected = "selected"><?=$row1["nick"];?></option>
                            <?php  $c =1;}else{
                            ?>

                            <option value="<?=$row1["idAutor"];?>"><?=$row1["nick"];?></option>
                            <?php

                        }
                        }
                        ?>
                    </select><br>


                    <label>What site is it on: </label>
                    <select name="select_create_site">
                        <?php
                        $conn = Connection::getPdoInstance();
                        $stmt1 = $conn->prepare("Select * from stranka");
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
                    </select><br>




                    <label>Name: </label><input type="text" name="name" value="<?php echo $name; ?>">

                    <br>
                    <label>Story Summary:</label>  <textarea name="summary" rows="5" cols="40"><?php echo $summary; ?></textarea>

                    <br>
                    <label>Link: </label><input type="text" name="link" value="<?php echo $link; ?>">

                    <br>

                    <input type="submit" name="submit1" value="Submit new fic"/>


                </form>
                <?php
                //implementation of form, taken from W3 school

                if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["submit1"])) {
                    if (empty($_POST["name"])) {
                        echo "<script type='text/javascript'>alert('Empty name');</script>";
                    } else if (empty($_POST['link'])) {
                        echo "<script type='text/javascript'>alert('Empty link');</script>";
                    } else if (!isset($_POST['select_create_tag']) or !isset($_POST['select_create_site']) or !isset($_POST['select_create_author'])) {
                        echo "<script type='text/javascript'>alert('Improperly Selected boxes');</script>";
                    } else {
                        $name = $_POST['name'];
                        if (!empty($_POST['summary'])) {
                            $summary = $_POST['summary'];
                        }

                        $link = $_POST['link'];
                        $choice1 = $_POST['select_create_tag'];
                        $choice2 = $_POST['select_create_author'];
                        $choice3 = $_POST['select_create_site'];
                        $conn = Connection::getPdoInstance();

                        $stmt1 = $conn->prepare("insert into story (storyName,storySummary,fk_Autorid,approved) values (:name,:summary,
        $choice2,1)");
                        $stmt1->bindParam(':name', $_POST["name"]);
                        $stmt1->bindParam(':summary', $_POST["summary"]);
                        $result1 = $stmt1->execute();

                        $last_id = $conn->lastInsertId();



                        // $stmt1->bindParam(':link', $_POST["link"]);
                        $stmt1 = $conn->prepare("insert into tagstory (fkStory,fkTag) values ('$last_id','$choice1')");
                        $result1 = $stmt1->execute();
                        //func();
                        echo "what the uck";
                        header("location". "stories.php");
                        //following script found on https://stackoverflow.com/questions/6985507/one-time-page-refresh-after-first-page-load
                        ?> <?php
                    }

                }






                ?>
            </div>
        </div>
    </main>
<?php
include 'elementals/footer.html';
?>
