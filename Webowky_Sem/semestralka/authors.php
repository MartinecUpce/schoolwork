<?php
/**
 * Created by PhpStorm.
 * User: Vojta
 * Date: 07/01/2019
 * Time: 17:32
 */
session_start();
include('elementals/header.php');
include("Connection.php");
$pdo = Connection::getPdoInstance();
$stmt = $pdo->prepare("SELECT * FROM autor");
$stmt->execute();
$result = $stmt -> fetchAll();


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
                    <?php if (!empty($_SESSION["user_id"]) and (!empty($_SESSION["logged"]) and $_SESSION["logged"] == 'admin')) { ?>
                        <th>Deletion</th>
                    <?php }?>

                </tr>

                <?php foreach( $result as $row ) { ?>
                <tr>   <td> <a href="./authorDisplay.php?idAutoria=<?php echo $row['idAutor']?>"><?php echo $row['nick'];?>
                    </a>   </td>
                    <td><?php echo $row['hodnoceni'] ?></td>
                    <?php if (!empty($_SESSION["user_id"]) and (!empty($_SESSION["logged"]) and $_SESSION["logged"] == 'admin')) { ?>
                        <td><form action= "" method="post">
                                <input type="hidden" name="id_story" value="<?= $row['idAutor'] ?>" />

                                <input type="submit" name="deletion" value="Delete" />
                            </form></td>
                    <?php }?>
                </tr>
                <?php }
                if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['deletion'])){
                    $relevantId = $_POST["idAutor"];
                    DeleteStory::deleteAutor($relevantId);
                }



                ?>

            </table>
        </div>
    </div>
</main>
<?php

include('elementals/footer.html')


?>