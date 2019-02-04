<?php
include 'Connection.php';
include 'elementals/header.php';
if(!empty($_SESSION)){
    header("Location:"."about2.php");
}
if(isset($_POST["register"])){
    $conn = Connection::getPdoInstance();
    if (empty($_POST["Password"]) or empty($_POST["Password1"])) {
        echo "<script type='text/javascript'>alert('Cannot have empty pass');</script>";
    }
    else if ($_POST["Password"] != $_POST["Password1"]) {
        echo "<script type='text/javascript'>alert('new passwords are not the same');</script>";
    }
        else if (empty($_POST["Mail"])) {
            echo "<script type='text/javascript'>alert('Cannot have empty mail');</script>";
        }
        else if (empty($_POST["nick"])) {
            echo "<script type='text/javascript'>alert('Cannot have empty nick');</script>";
        }
         else {
            try {
                $paff = md5($_POST['Password']);

                $stmt = $conn->prepare("insert into uzivatel (userNick,userPassword,userMail,role) values(:Nick,'$paff',:Email,'user')");
                $stmt->bindParam(':Email', $_POST['Mail']);
                $stmt->bindParam(':Nick', $_POST['nick']);

                    $stmt->execute();

               // echo "<script type='text/javascript'>window.location.href = 'about2.php';</script>";
            } catch (PDOException $ex) {
              echo $ex;
                //  echo "<script type='text/javascript'>alert('This email is already in use $ex');</script>";
            }


        }


}
?>
    <main>
        <link rel="stylesheet" type="text/css" href="css/test1.css">
        <link rel="stylesheet" type="text/css" href="/css/test2.css">
        <div class="center-wrapper">
            <div>

                <p>
                <form method="post">

                    <input type="email" name="Mail" placeholder="Insert your email">
                    <input type="text" name="nick" value="Insert nick">
                    <input type="password" name="Password" placeholder="Insert password">
                    <input type="password" name="Password1" placeholder="Verify password">
                    <input type="submit" name="register" value="Register">

                </form>
                </p>
            </div>
        </div>
    </main>
<?php
include 'elementals/footer.html';
?>