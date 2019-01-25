<?php
/**
 * Created by PhpStorm.
 * User: Vojta
 * Date: 07/01/2019
 * Time: 18:17
 */
/*if (session_status() == PHP_SESSION_NONE) {
    session_start();
}*/

include 'elementals/header.php';
if(!empty($_SESSION)){
    //include 'delet.php';
    include 'DeleteStory.php';

}
else{
    include 'Connection.php';
}
$relevantId;
//include 'delet.php';
?>
    <main>
        <link rel="stylesheet" type="text/css" href="css/test1.css">
        <link rel="stylesheet" type="text/css" href="../css/test2.css">
        <link rel="stylesheet" type="text/css" href="../css/forms.css">
        <div class="center-wrapper">
            <div>
                <h2>Stories</h2>
                <?php
                $conn = Connection::getPdoInstance();
                $stmt1 = $conn->prepare("Select tagName from tag");
                $result1 = $stmt1->execute();
                $result1 = $stmt1 ->fetchAll();
                ?>
                <form action="" method="post">
                <label>Sort tags: </label><select name="select_tag">
                    <?php
                    $i = 0;
                    foreach($result1 as $row1) {
                        if($i == 0) {?>
                        <option value="<?=$row1["tagName"];?>"><?=$row1["tagName"];?></option>
                        <?php
                            $i = 1;
                        }
                        else{
                            ?>
                            <option value="<?=$row1["tagName"];?>"><?=$row1["tagName"];?></option>
                            <?php
                        }


                    }
                    ?>
                </select>
                <input type="submit" name="sort" value="Sort"/>
                    <input type="submit" name="unsort" value="Unsort" />
                </form>
                <?php

                //taken from StackOverflow
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['unsort']))
    {
        func();
    }
    else if(isset($_POST['select_tag']) and isset($_POST['sort'])){
                $choice= $_POST['select_tag'];
                $pdo1 = Connection::getPdoInstance();
                //$stmt = $pdo->prepare("SELECT * FROM story");
                $stmt2 = $pdo1->prepare("SELECT distinct story.approved,tag.tagName,tag.idTag,story.hodnoceni,story.idStory,story.storyName,story.storySummary FROM story JOIN tagstory t on story.idStory = t.fkStory join tag on t.fkTag = tag.idTag where tag.tagName = '$choice'");
                $stmt2->execute();
                $result2 = $stmt2 -> fetchAll();
                ?>
                  <label>sorted by: <?php echo $choice ?></label>
                  <table>
                    <tr>
                        <th>Name of story</th>
                        <th>Rating</th>
                        <th>Brief Summary(if present)</th>
                        <?php if (!empty($_SESSION["user_id"]) and (!empty($_SESSION["logged"]) and $_SESSION["logged"] == 'admin')) { ?>
                            <th>Deletion</th>
                        <?php }?>

                    </tr>

                    <?php foreach( $result2 as $row2 ) {
                        func2($row2["idStory"]);
                        if($row2['approved'] !=0){
                            ?>

                            <tr>
                                <td> <a href="./storyDisplay.php?storyId=<?php echo $row2['idStory']?>">
                                        <?php echo $row2['storyName']?>
                                    </a>   </td>
                                <td><?php echo $row2['hodnoceni'] ?></td>
                                <td><?php
                                    $str = $row2['storySummary'] ;
                                    echo wordwrap($str,50,"<br>\n");
                                    //echo $row2['storySummary']
                                    ?></td>
                                <?php if (!empty($_SESSION["user_id"]) and (!empty($_SESSION["logged"]) and $_SESSION["logged"] == 'admin')) { ?>
                                    <td><form action= "" method="post">
                                            <input type="hidden" name="id_story" value="<?= $row2['idStory'] ?>" />

                                            <input type="submit" name="deletion" value="Delete" />
                                        </form>

                                    </td>

                                <?php }?>
                            </tr>

                        <?php } } ?>
                </table><?php
        }
         else{
             func();
             }
         if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['deletion'])){
             $relevantId = $_POST["id_story"];
                    DeleteStory::deleteStory($relevantId);
         }



?>

            </div>
            <?php if (!empty($_SESSION["user_id"])) {?>
            <h2 align="center"><a href = "storyCreation.php">Submit new story</a></h2>
            <?php } ?>

        </div>
    </main>
<?php
include 'elementals/footer.html';
function func2($param){
    $pdo = Connection::getPdoInstance();

    $stmt = $pdo->prepare("Select IFNULL(AVG(hodnoceni),0) from review where fkStoryid = $param");
    $stmt->execute();
    $res = $stmt->fetchColumn();

    $stmt = $pdo->prepare("Update story set hodnoceni =$res where idStory = $param");
    $stmt->execute();
}
function func()
{
    $pdo = Connection::getPdoInstance();
    $stmt = $pdo->prepare("SELECT * FROM story");
    $stmt->execute();
    $result = $stmt -> fetchAll();
    ?>
    <table>
        <tr>
            <th>Name of story</th>
            <th>Rating</th>
            <th>Brief Summary(if present)</th>
            <?php if (!empty($_SESSION["user_id"]) and (!empty($_SESSION["logged"]) and $_SESSION["logged"] == "admin")) { ?>
                <th> Deletion </th>
            <?php }?>
        </tr>

        <?php foreach( $result as $row ) {
            func2($row['idStory']);
            if($row['approved'] !=0){

                ?>

                <tr>
                    <td> <a href="./storyDisplay.php?storyId=<?php echo $row['idStory']?>">
                            <?php echo $row['storyName']?>
                        </a>   </td>
                    <td><?php echo $row['hodnoceni'] ?></td>
                    <td><?php
                        $str = $row['storySummary'] ;
                        echo wordwrap($str,50,"<br>\n");
                        //echo $row['storySummary']
                        ?></td>
                    <?php if (!empty($_SESSION["user_id"]) and (!empty($_SESSION["logged"]) and $_SESSION["logged"] == 'admin')) { ?>
                        <td>
                            <form action= "" method="post">
                                <input type="hidden" name="id_story" value="<?= $row['idStory'] ?>" />
                                <input type="submit" name="deletion" value="Delete" />
                            </form>
                            <?php

                            ?>
                            </td>
                    <?php }?>
                </tr>

            <?php } }
        if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['deletion'])){
            $someId = $_POST['id_story'];
            DeleteStory::deleteStory($someId);//($row['idStory']);
        }?>
    </table>
    <?php
}
function func1()
{
    $pdo = Connection::getPdoInstance();
    $stmt = $pdo->prepare("SELECT * FROM story");
    $stmt->execute();
    $result = $stmt -> fetchAll();
    ?>
    <table>
        <tr>
            <th>Name of story</th>
            <th>Rating</th>
            <th>Brief Summary(if present)</th>

        </tr>

        <?php foreach( $result as $row ) {
            func2($row['idStory']);
            if($row['approved'] !=0){

                ?>

                <tr>
                    <td> <a href="./storyDisplay.php?storyId=<?php echo $row['idStory']?>">
                            <?php echo $row['storyName']?>
                        </a>   </td>
                    <td><?php echo $row['hodnoceni'] ?></td>
                    <td><?php
                        $str = $row['storySummary'] ;
                        echo wordwrap($str,50,"<br>\n");
                        //echo $row['storySummary']
                        ?></td>

                </tr>

            <?php } } ?>
    </table>
    <?php
}





/*$pdo = Connection::getPdoInstance();
$stmt = $pdo->prepare("SELECT * FROM story");
$stmt->execute();
$result = $stmt -> fetchAll();

<a href="delet.php?delid=<?php echo $row['idStory']?>&tablaName=story">Deletion</a>
*/




?>


