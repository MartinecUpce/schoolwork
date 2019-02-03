<?php
/**
 * Created by PhpStorm.
 * User: Vojta
 * Date: 07/01/2019
 * Time: 17:32
 */
session_start();
include('elementals/header.php');
//include("Connection.php");
include("DeleteStory.php");
$pdo = Connection::getPdoInstance();
$stmt = $pdo->prepare("SELECT * FROM autor");
$stmt->execute();
$result = $stmt -> fetchAll();
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['deletion'])){
    $relevantId = $_POST["id_autor"];
    DeleteStory::deleteAutor($relevantId);
}
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['edition'])){
    $relevantId = $_POST["id_autor"];
    header("Location:"."editAuthor.php?idAuthor=$relevantId");
}

?>
<main>
    <link rel="stylesheet" type="text/css" href="css/test1.css">
    <link rel="stylesheet" type="text/css" href="../css/test2.css">
    <div class="center-wrapper">
        <div>
            <h2>Authors</h2>

            <table>
                <tr>
                    <th>Nick</th>
                    <th>Rating</th>
                    <th>Info (if insubstantial)</th>
                    <?php if (!empty($_SESSION["user_id"]) and (!empty($_SESSION["logged"]) and $_SESSION["logged"] == 'admin')) { ?>
                        <th>Deletion</th>
                    <?php }?>

                </tr>

                <?php foreach( $result as $row ) { ?>
                <tr>   <td> <a href="./authorDisplay.php?idAutoria=<?php echo $row['idAutor']?>"><?php echo $row['nick'];?>
                    </a>   </td>
                    <td><?php echo $row['hodnoceni'] ?></td>
                    <td> <?php $str = $row['info'] ;
                        echo wordwrap($str,50,"<br>\n"); ?></td>
                    <?php if (!empty($_SESSION["user_id"]) and (!empty($_SESSION["logged"]) and $_SESSION["logged"] == 'admin')) { ?>
                        <td><form action= "" method="post">
                                <input type="hidden" name="id_autor" value="<?= $row['idAutor'] ?>" />

                                <input type="submit" name="deletion" value="Delete" />
                                <input type="submit" name="edition" value="Edit" />
                            </form></td>
                    <?php }?>
                </tr>
                <?php }




                ?>


            </table>
        </div>
        <?php if (!empty($_SESSION["user_id"])) {?>
            <h2 align="center"><a href = "authorCreation.php">Submit new author</a></h2>
        <?php } ?>
    </div>
</main>
<?php

include('elementals/footer.html')


?>