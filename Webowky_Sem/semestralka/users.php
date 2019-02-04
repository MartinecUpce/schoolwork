<?php
include 'elementals/header.php';
include 'DeleteStory.php';

$conn = Connection::getPdoInstance();

if(empty($_SESSION) or $_SESSION["logged"] != "admin"){
    header("Location:". "about2.php");
    exit();
}
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['deletion'])){
    $someId = $_POST['idUser'];
    DeleteStory::deleteUser($someId);//($row['idStory']);
}
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['edition'])){
    $someId = $_POST['idUser'];
    header("Location:" . "userEdit.php?idUser=$someId");
    //($row['idStory']);
}



$stmt = $conn->prepare("SELECT userNick,userMail,role,idUzivatel FROM uzivatel");
$stmt->execute();
$result = $stmt -> fetchAll();

?>

    <link rel="stylesheet" type="text/css" href="css/test1.css">
    <link rel="stylesheet" type="text/css" href="css/test2.css">
    <main>

        <div class="center-wrapper">
            <div>
                <h2>Users</h2>
                <table>
                    <tr>
                        <th>Nick</th>
                        <th>Email</th>
                        <th>Power</th>
                        <th>Manage</th>
                    </tr>

                    <?php foreach( $result as $row ) {

                        ?>
                        <tr>
                            <td> <?php echo $row["userNick"] ?></td>
                            <td><?php echo $row['userMail']?></td>
                            <td><?php echo $row['role']?></td>
                            <?php if($row['role']== 'user'){ ?>

                                <td>
                                    <form method="post">

                                        <input type="hidden" name="idUser" value="<?= $row['idUzivatel'] ?>" />
                                        <input type="submit" name="deletion" value="Delete" />
                                        <input type="submit" name="edition" value="Edit" />
                                    </form>
                                </td>

                            <?php } ?>

                        </tr>
                        <?php
                    } ?>

                </table>

            </div>

        </div>
    </main>
    <br>
    <br>
    <br>
<?php
include 'elementals/footer.html';
?>