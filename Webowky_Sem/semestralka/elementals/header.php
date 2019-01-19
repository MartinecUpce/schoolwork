<?php
session_start();
?>




<!DOCTYPE html>
<html lang="en">

    <meta charset="UTF-8">

    <link rel="stylesheet" type="text/css" href="../css/test1.css">
    <link rel="stylesheet" type="text/css" href="../css/test2.css">
    <body>





    <header><nav id="nav">
        <a href="about2.php">About</a>
        <a href="sites.php">Sites</a>
        <a href="authors.php">Authors</a>
        <a href="stories.php">Stories</a>

            <?php if (!empty($_SESSION["user_id"])) { ?>
                <a href="users.php">User</a>
                <a href="logout.php">Logout</a>
            <?php } else { ?>
                <a href="login.php">Login</a>
            <?php } ?>
    </nav></header>
    </body>
    <section id="hero">
        <div>
            <h1>Review internet authors, find the best ones</h1>

        </div>
    </section>
</html>
