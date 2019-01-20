
<?php
/**
 * Created by PhpStorm.
 * User: Vojta
 * Date: 20/01/2019
 * Time: 18:05
 */
include 'Connection.php';
if((!empty($_GET['delid']) or !empty($_GET['tablaName'])) and $_SESSION["logged"] == "admin"){
    $tbl = $_GET['tablaName'];
    $id = $_GET['delid'];
    echo $tbl;
    echo $id;
if( isset($_GET['delid']) and isset($_GET['tablaName']) and $_SESSION["logged"] == "admin") { // if delete was requested AND an id is present...

    $conn = Connection::getPdoInstance();
    $tbl = $_GET['tablaName'];
    $id = $_GET['delid'];
    echo $tbl;
    echo $id;
    $stmt = $conn->prepare("DELETE FROM $tbl WHERE idStory = $id");
    $stmt->execute();
    header("location:" . "stories.php");
}
}
/*else{
    header("location:" . "stories.php");
}*/
