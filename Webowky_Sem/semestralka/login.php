
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

include 'config.php';

if (!empty($_POST) && !empty($_POST["loginMail"]) && !empty($_POST["loginPassword"])) {

    //connect to database
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //get user by email and password
    $stmt = $conn->prepare("SELECT idUzivatel, userNick, userMail FROM uzivatel 
                                      WHERE userMail= :email and userPassword = :password");
    $stmt->bindParam(':email', $_POST["loginMail"]);
    $stmt->bindParam(':password', $_POST["loginPassword"]);
    $stmt->execute();
    $uzivatel = $stmt->fetch();
    if (!$uzivatel) {
        echo "user not found";
    } else {
        echo "you are logged in. Your ID is: " . $uzivatel["idUzivatel"];
        $_SESSION["user_id"] = $uzivatel["idUzivatel"];
        $_SESSION["username"] = $uzivatel["userNick"];
        $_SESSION["email"] = $uzivatel["userMail"];
        $_SESSION["logged"] = "true";
        header("Location:" . "about2.php");
    }

} else if (!empty($_POST)) {
    echo "Username and password are required";
}


?>


<main>
    <link rel="stylesheet" type="text/css" href="css/test1.css">
    <div class="center-wrapper">
        <div>
            <h2>Login formula</h2>
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
include 'elementals/footer.html';
?>