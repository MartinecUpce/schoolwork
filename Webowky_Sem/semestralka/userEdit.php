<?php
/**
 * Created by PhpStorm.
 * User: Vojta
 * Date: 03/02/2019
 * Time: 10:22
 */
include 'elementals/header.php';
include "DeleteStory.php";
if(empty($_GET["idUser"])or empty($_SESSION)) {
    header("Location:" . "about2.php");
    exit();
}
$conn = Connection::getPdoInstance();
$idUziv = $_GET["idUser"];
if(isset($_POST["makeAdmin"])){
    $conn = Connection::getPdoInstance();
    $stmt = $conn->prepare("update uzivatel set role='admin' where idUzivatel = $idUziv");
    $stmt->execute();
    echo "<script type='text/javascript'>window.location.href = 'users.php';</script>";
}
if(isset($_POST["unmakeAdmin"])){
    $conn = Connection::getPdoInstance();
    $stmt = $conn->prepare("update uzivatel set role='user' where idUzivatel = $idUziv");
    $stmt->execute();
    echo "<script type='text/javascript'>window.location.href = 'users.php';</script>";
}
if(isset($_POST["editPassword"])){
    if(empty($_POST["newPassword"])){
        echo "<script type='text/javascript'>alert('Cannot have empty password!!!!');</script>";
    }else{
        try{
            $pass = md5($_POST["newPassword"]);
            $stmt = $conn->prepare("update uzivatel set userPassword='$pass' where idUzivatel = $idUziv");
            $stmt->execute();
        }catch(PDOException $ex){
            echo "<script type='text/javascript'>alert('Problem in database!!!!');</script>";
        }
    }

}


    $stmt = $conn->prepare("select * from uzivatel where idUzivatel = $idUziv");
    $stmt->execute();
    $res = $stmt->fetch();
?>
    <main>
        <link rel="stylesheet" type="text/css" href="css/test1.css">
        <link rel="stylesheet" type="text/css" href="../css/test2.css">
        <div class="center-wrapper">
            <div>
                <h2>Edit user <?php echo $res["userNick"];?></h2>
                <p>
                <?php if($res["role"] == 'user'){ ?>
                <form method="post">

                    <input class="p2" type="submit" name="makeAdmin" value="Grant admin rights"/>
                </form>
                <?php }
                else{ ?>
                    <form method="post">

                    <input class="p2" type="submit" name="unmakeAdmin" value="Revoke admin rights"/>
                </form>
                <?php } ?>
            </p>
                <p>
                    <form method="post">
                    <input type="password" name="newPassword" placeholder="new password">
                    <input class="p2" type="submit" name="editPassword" value="Edit password"/>
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