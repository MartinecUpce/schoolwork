<?php
/**
 * Created by PhpStorm.
 * User: Vojta
 * Date: 03/02/2019
 * Time: 13:28
 */



include "Connection.php";
if(empty($_GET["idSite"])){
    header("Location:"."sites.php");
    exit();
}
$idSite = $_GET["idSite"];
$conn = Connection::getPdoInstance();


if(isset($_POST["editName"])){
    if (empty($_POST["name"])) {
        echo "<script type='text/javascript'>alert('Empty name');</script>";
    }
    else{
        try {
            $conn = Connection::getPdoInstance();
            $stmt = $conn->prepare("update stranka set jmeno=:name where id_Stranka = $idSite");
            $stmt->bindParam(':name', $_POST["name"]);

            $stmt->execute();

        }catch(PDOException $ex){
            echo "<script type='text/javascript'>alert('Site like that already exists')</script>";
        }
    }
}
if(isset($_POST["editLink"])){
    if (empty($_POST['link'])) {
        echo "<script type='text/javascript'>alert('Empty link');</script>";
    }
    else{
        try {
            $conn = Connection::getPdoInstance();
            $stmt = $conn->prepare("update stranka set link=:link where id_Stranka = $idSite");

            $stmt->bindParam(':link', $_POST["link"]);
            $stmt->execute();

        }catch(PDOException $ex){
            echo "<script type='text/javascript'>alert('Something went wrong')</script>";
        }
    }
}
if(isset($_POST["editInfo"])){


        try {
            $conn = Connection::getPdoInstance();
            $stmt = $conn->prepare("update stranka set popisek=:popisek where id_Stranka = $idSite");

            $stmt->bindParam(':popisek', $_POST["info"]);
            $stmt->execute();

        }catch(PDOException $ex){
            echo "<script type='text/javascript'>alert('Something went wrong')</script>";
        }

}
$stmt = $conn->prepare("select * from stranka where id_Stranka = $idSite");

$stmt->execute();
$strankaRes = $stmt->fetch();
$nick = $strankaRes["jmeno"];
$info =$strankaRes["popisek"];
$link = $strankaRes["link"];

include 'elementals/header.php';
if(empty($_SESSION["user_id"])){
    header("Location:"."sites.php");
    exit();

}
?>
    <main>
        <link rel="stylesheet" type="text/css" href="css/test1.css">
        <link rel="stylesheet" type="text/css" href="css/test2.css">
        <div class="center-wrapper">
            <h2 align="center">Submit another site</h2>
            <form action="" method="post">
            <p>
                <label>Name of site: </label>
                <input type="text" name="name" value="<?php echo $nick; ?>">
                <input type="submit" name="editName" value="Edit name"/>
            </p>
            </form>
                <br>
            <form action="" method="post">
                <p>
                <label>Info:</label>  <textarea name="info" rows="5" cols="40" maxlength="1000"><?php echo $info; ?></textarea>
                    <input type="submit" name="editInfo" value="Edit info"/>
                </p>
            </form>
                <br>
            <form action="" method="post">
                <p>
                <label>Link: </label><input type="text" name="link" value="<?php echo $link; ?>">
                    <input type="submit" name="editLink" value="Edit link"/>
                </p>
            </form>
                <br>


            </form>



        </div>
    </main>
    <br>
    <br>
    <br>
<?php
include 'elementals/footer.html';
?>