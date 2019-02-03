<?php
include 'elementals/header.php';
include 'DeleteStory.php';

$pdo = Connection::getPdoInstance();

if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['deletion'])){
    $someId = $_POST['id_Site'];
    DeleteStory::deleteSite($someId);//($row['idStory']);
}
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['edition'])){
    $someId = $_POST['id_Site'];
    header("Location:" . "editSite.php?idSite=$someId");
    //($row['idStory']);
}


$stmt = $pdo->prepare("SELECT * FROM stranka");
$stmt->execute();
$result = $stmt -> fetchAll();

?><link rel="stylesheet" type="text/css" href="css/test1.css">
    <link rel="stylesheet" type="text/css" href="../css/test2.css">
    <main>

        <div class="center-wrapper">
            <div>
                <h2>Sites</h2>
                <table>
                    <tr>
                        <th>Name</th>

                        <th>Brief Introduction</th>
                        <th>editing</th>
                    </tr>

                    <?php foreach( $result as $row ) {
                        if($row["id_Stranka"] != 0){
                        ?>
                        <tr>   <td> <a href="<?php echo $row['link']?>"><?php echo $row['jmeno'];?>
                                </a>   </td>

                            <td><?php
                                $str = $row['popisek'] ;
                                echo wordwrap($str,50,"<br>\n");
                                 ?></td>
                            <?php if (!empty($_SESSION["user_id"]) ) { ?>
                                <td><form action= "" method="post">
                                        <input type="hidden" name="id_Site" value="<?= $row['id_Stranka'] ?>" />
                                        <?php if (!empty($_SESSION["logged"]) and $_SESSION["logged"] == 'admin'){?>
                                        <input type="submit" name="deletion" value="Delete" />
                                                <?php }?>
                                        <input type="submit" name="edition" value="Edit" />
                                    </form>

                                </td>
                            <?php }?>
                        </tr>
                    <?php
                        }
                    } ?>

                </table>

            </div>
            <?php if (!empty($_SESSION["user_id"])) {?>
                <h2 align="center"><a href = "siteCreation.php">Submit new story</a></h2>
            <?php } ?>
        </div>
    </main>
<br>
<br>
<br>
<?php
include 'elementals/footer.html';
?>