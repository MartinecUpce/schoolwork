<?php
/**
 * Created by PhpStorm.
 * User: Vojta
 * Date: 03/02/2019
 * Time: 19:56
 */
include 'elementals/header.php';
include 'DeleteStory.php';
if($_SESSION["logged"]!= 'admin'){
    header("Location:"."about2.php");
    exit();
}
if(isset($_POST["approval"])){
    $conn = Connection::getPdoInstance();
    $id = $_POST["id_autor"];
    $stmt = $conn->prepare("update autor set approved=1 where idAutor = $id");
    $stmt->execute();

}
if(isset($_POST["approvalStory"])){
    $conn = Connection::getPdoInstance();
    $id = $_POST["id_story"];
    $stmt = $conn->prepare("update story set approved=1 where idStory = $id");
    $stmt->execute();

}
$pdo = Connection::getPdoInstance();
$stmt = $pdo->prepare("SELECT * FROM autor");
$stmt->execute();
$result = $stmt -> fetchAll();
$pdo = Connection::getPdoInstance();
$stmt = $pdo->prepare("SELECT * FROM story");
$stmt->execute();
$resultStory = $stmt -> fetchAll();

?>
    <main>
        <link rel="stylesheet" type="text/css" href="css/test1.css">
        <link rel="stylesheet" type="text/css" href="css/test2.css">
        <div class="center-wrapper">
            <div>

                <h2 align="center">Authors</h2>

                <table>
                    <tr>
                        <th>Nick</th>
                        <th>Rating</th>
                        <th>Info (if insubstantial)</th>
                        <?php if (!empty($_SESSION["user_id"]) and (!empty($_SESSION["logged"]) and $_SESSION["logged"] == 'admin')) { ?>
                            <th>Approve</th>
                        <?php }?>

                    </tr>

                    <?php foreach( $result as $row ) {
                        if($row["approved"] == 0){
                        ?>

                        <tr>   <td> <a href="./authorDisplay.php?idAutoria=<?php echo $row['idAutor']?>"><?php echo $row['nick'];?>
                                </a>   </td>
                            <td><?php echo $row['hodnoceni'] ?></td>
                            <td> <?php $str = $row['info'] ;
                                echo wordwrap($str,50,"<br>\n"); ?></td>
                            <?php if (!empty($_SESSION["user_id"]) and (!empty($_SESSION["logged"]) and $_SESSION["logged"] == 'admin')) { ?>
                                <td><form action= "" method="post">
                                        <input type="hidden" name="id_autor" value="<?= $row['idAutor'] ?>" />

                                        <input type="submit" name="approval" value="Approve" />

                                    </form></td>
                            <?php }?>
                        </tr>
                    <?php }
                    }




                    ?>


                </table>
                <h2 align="center">Stories</h2>
                <table>
                    <tr>
                        <th>Name of story</th>
                        <th>Rating</th>
                        <th>Brief Summary(if present)</th>

                            <th> Approve </th>

                    </tr>

                    <?php foreach( $resultStory as $row ) {
                        //  func2($row['idStory']);
                        if($row['approved'] ==0 ){

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
                                   <td>
                                        <form action= "" method="post">
                                            <input type="hidden" name="id_story" value="<?= $row['idStory'] ?>" />

                                            <input type="submit" name="approvalStory" value="Approve" />
                                        </form>

                                    </td>

                            </tr>

                        <?php }
                    }
                    ?>
                </table>
            </div>
        </div>
    </main>
<?php
include 'elementals/footer.html';
?>