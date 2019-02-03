<?php
/**
 * Created by PhpStorm.
 * User: Vojta
 * Date: 03/02/2019
 * Time: 13:28
 */



include "Connection.php";
$nick ="";
$info ="";
$link = "";
if(isset($_POST["submit2"])){
    if (empty($_POST["name"])) {
        echo "<script type='text/javascript'>alert('Empty name');</script>";
    } else if (empty($_POST['link'])) {
        echo "<script type='text/javascript'>alert('Empty link');</script>";
    }
    else{
        try {
            $conn = Connection::getPdoInstance();
            $stmt = $conn->prepare("insert into stranka(link,jmeno,popisek) values(:link,:name,:info)");
            $stmt->bindParam(':name', $_POST["name"]);
            $stmt->bindParam(':info', $_POST["info"]);
            $stmt->bindParam(':link', $_POST["link"]);
            $stmt->execute();
            echo "<script type='text/javascript'>window.location.href = 'sites.php';</script>";
        }catch(PDOException $ex){
            echo "<script type='text/javascript'>alert('Site like that already exists')</script>";
        }
    }
}

include 'elementals/header.php';
if(empty($_SESSION["user_id"])){
    header("Location:"."sites.php");
    exit();

}
?>
    <main>
        <link rel="stylesheet" type="text/css" href="css/test1.css">
        <link rel="stylesheet" type="text/css" href="../css/test2.css">
        <div class="center-wrapper">
            <h2 align="center">Submit another site</h2>
            <form action="" method="post">


                <label>Name of site: </label><input type="text" name="name" value="<?php echo $nick; ?>">

                <br>
                <label>Info:</label>  <textarea name="info" rows="5" cols="40" maxlength="1000"><?php echo $info; ?></textarea>

                <br>
                <label>Link: </label><input type="text" name="link" value="<?php echo $link; ?>">

                <br>

                <input type="submit" name="submit2" value="Submit new site"/>
            </form>



        </div>
    </main>
<br>
<br>
<br>
<?php
include 'elementals/footer.html';
?>