<?php
/**
 * Created by PhpStorm.
 * User: Vojta
 * Date: 19/01/2019
 * Time: 17:24
 */

include 'elementals/header.php';
include "Connection.php";
if(!empty($_SESSION)) {
    $pdo = Connection::getPdoInstance();
    $id = $_SESSION["user_id"];
    $stmt = $pdo->prepare("select * from uzivatel where idUzivatel = $id");

    $stmt->execute();
    $result = $stmt->fetch();
    ?>
    <main>
        <link rel="stylesheet" type="text/css" href="css/test1.css">
        <link rel="stylesheet" type="text/css" href="../css/test2.css">
        <div class="center-wrapper">
            <div>
                <h2>Welcome user <?php echo $result["userNick"]; ?></h2>
                <p>
                    You have <?php
                    $stmt = $pdo->prepare("select IFNULL(count(*), 0) from zprava where Recipient = $id and readit = 0");
                    $stmt->execute();
                    $howMany = $stmt->fetchColumn();
                    echo $howMany;
                    ?> unread messages;
                </p>
            </div>
        </div>
    </main>


<?php

}else{
    ?>
<main>
    <link rel="stylesheet" type="text/css" href="css/test1.css">
    <link rel="stylesheet" type="text/css" href="../css/test2.css">
    <div class="center-wrapper">
        <div>
            <h2 align = center>You have no business being here, snooper</h2>

        </div>
    </div>
</main>
<?php
}
include 'elementals/footer.html';
?>