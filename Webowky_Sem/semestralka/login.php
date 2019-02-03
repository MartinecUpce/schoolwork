
<?php
/**
 * Created by PhpStorm.
 * User: Vojta
 * Date: 07/01/2019
 * Time: 18:17
 */

include 'elementals/header.php';
?>

<?php

//include 'config.php';
include 'Connection.php';

if (!empty($_POST) && !empty($_POST["loginMail"]) && !empty($_POST["loginPassword"])) {

    //connect to database
    $conn = Connection::getPdoInstance();//new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
   // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //get user by email and password
    $pass = md5($_POST["loginPassword"]);
    $stmt = $conn->prepare("SELECT idUzivatel, userNick, userMail,role FROM uzivatel 
                                      WHERE userMail= :email and userPassword = '$pass'");
    $stmt->bindParam(':email', $_POST["loginMail"]);
    //$stmt->bindParam(':password', $_POST["loginPassword"]);
    $stmt->execute();
    $uzivatel = $stmt->fetch();
    if (!$uzivatel) {
        echo "<script type='text/javascript'>alert('user not found');</script>";
    } else {
        echo "you are logged in. Your ID is: " . $uzivatel["idUzivatel"];
        $_SESSION["user_id"] = $uzivatel["idUzivatel"];
        $_SESSION["username"] = $uzivatel["userNick"];
        $_SESSION["email"] = $uzivatel["userMail"];
        $_SESSION["jeAdmin"] = $uzivatel["userMail"];
        $_SESSION["logged"] = $uzivatel["role"];
        header("Location:" . "about2.php");
    }

} else if (!empty($_POST)) {
    echo "<script type='text/javascript'>alert('Username and password required');</script>";
}


?>


<main>
    <link rel="stylesheet" type="text/css" href="css/test1.css">
    <link rel="stylesheet" type="text/css" href="../css/test2.css">
    <div class="center-wrapper">
        <div>
            <h2>Login</h2>
            <p>
            <form method="post">

                <input type="email" name="loginMail" placeholder="Insert your email">
                <input type="password" name="loginPassword" placeholder="Password">
                <input type="submit" value="Log in">

            </form>

            </p>
        </div>
    </div>
</main>




<?php
/*password_verify($_POST['loginPassword'], $user['heslo']);
na přihlášení
$newPass = password_hash($_POST["psw"], PASSWORD_BCRYPT);*/
include 'elementals/footer.html';
?>