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
    $conn = Connection::getPdoInstance();


    $id = $_SESSION["user_id"];
    $stmt = $conn->prepare("select * from uzivatel where idUzivatel = $id");
    $stmt->execute();
    $result = $stmt->fetch();

    if (isset($_POST["editMail"])) {
        if (empty($_POST["newEmail"])) {
            echo "<script type='text/javascript'>alert('Cannot have empty mail');</script>";
        }
        else if (empty($_POST["oldPassword"])) {
            echo "<script type='text/javascript'>alert('Cannot have empty verification');</script>";
        } else {
            try {
                $stmt = $conn->prepare("SELECT userPassword FROM uzivatel where idUzivatel = $id");
                $pass = md5($_POST["oldPassword"]);
                    $stmt->execute();
                $res = $stmt->fetchColumn();

                if($res != $pass){

                    echo "<script type='text/javascript'>alert('Invalid verification password');</script>";
                }
                else {
                    $stmt1 = $conn->prepare("update uzivatel set userMail=:newEmail where idUzivatel = $id");
                    $stmt1->bindParam(':newEmail', $_POST['newEmail']);
                    $stmt1->execute();
                }
               // echo "<script type='text/javascript'>window.location.href = 'about2.php';</script>";
            } catch (PDOException $ex) {
                echo "<script type='text/javascript'>alert('This email is already in use');</script>";
        }


        }

    }
    if (isset($_POST["editPassword"])) {
        if (empty($_POST["newPassword"]) or empty($_POST["newPassword2"])) {
            echo "<script type='text/javascript'>alert('Cannot have empty pass');</script>";
        }

        else if ($_POST["newPassword"] != $_POST["newPassword2"]) {

            echo "<script type='text/javascript'>alert('new passwords are not the same');</script>";
        }
     else if (empty($_POST["oldPassword2"])) {
        echo "<script type='text/javascript'>alert('Cannot have empty verification');</script>";
    } else {
        try {
            $stmt = $conn->prepare("SELECT userPassword FROM uzivatel where idUzivatel = $id");
            $pass = md5($_POST["oldPassword2"]);
            $stmt->execute();

            $res = $stmt->fetchColumn();

            if($pass != $res){

                echo "<script type='text/javascript'>alert('Invalid verification password');</script>";
            }
            else {
                $passIn = md5($_POST['newPassword']);
                $stmt1 = $conn->prepare("update uzivatel set userPassword='$passIn' where idUzivatel = $id");

                $stmt1->execute();
            }
          //  echo "<script type='text/javascript'>window.location.href = 'about2.php';</script>";
        } catch (PDOException $ex) {
            echo $ex;
            echo "<script type='text/javascript'>alert('This email is already in use');</script>";
        }


    }
}

    if (isset($_POST["editNick"])) {
        if (empty($_POST["newNick"])) {
            echo "<script type='text/javascript'>alert('Cannot have empty nick');</script>";
        }
        else if (empty($_POST["oldPassword3"])) {
            echo "<script type='text/javascript'>alert('Cannot have empty verification');</script>";
        } else {
            try {
                $stmt = $conn->prepare("SELECT userPassword FROM uzivatel where idUzivatel = $id");
                $pass = md5($_POST["oldPassword3"]);
$stmt->execute();
                $res = $stmt->fetchColumn();
                if($pass != $res){
                    echo "<script type='text/javascript'>alert('Invalid verification password');</script>";
                }
                else {
                    $stmt1 = $conn->prepare("update uzivatel set userNick=:newNick where idUzivatel = $id");
                    $stmt1->bindParam(':newNick', $_POST['newNick']);
                    $stmt1->execute();
                }
                header("Location:"."about2.php");
                //echo "<script type='text/javascript'>window.location.href = 'about2.php';</script>";
            } catch (PDOException $ex) {
                echo "<script type='text/javascript'>alert('This nick is suspicious');</script>";
            }


        }
    }

    ?>
    <main>
        <link rel="stylesheet" type="text/css" href="css/test1.css">
        <link rel="stylesheet" type="text/css" href="../css/test2.css">
        <div class="center-wrapper">
            <p>
                <h2>Welcome user <?php echo $result["userNick"]; ?></h2>
                <p>
                   <form action="" method="post">
                    <input type="email" name="newEmail" placeholder="Insert your email">
                <input type="password" name="oldPassword" placeholder="verify old password">
                    <input type="submit" name="editMail" value="Edit Email"/>
                </form>
            </p>
            <p>
            <form action="" method="post">

                <input type="password" name="newPassword2" placeholder="new password">
                    <input type="password" name="newPassword" placeholder="control new password">

                <input type="password" name="oldPassword2" placeholder="verify old password">
                <input type="submit" name="editPassword" value="Edit Password"/>
            </p>

            </form>
            <p>
            <form action="" method="post">
                <input type="text" name="newNick" value="new nick here">
                <input type="password" name="oldPassword3" placeholder="verify old password">

                <input type="submit" name="editNick" value="Edit Nick"/>

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
    <br>
    <br>
    <br>
    <br>

<?php
}
include 'elementals/footer.html';
?>