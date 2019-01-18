<?php
/**
 * Created by PhpStorm.
 * User: Vojta
 * Date: 07/01/2019
 * Time: 17:32
 */
session_start();
include('elementals/header.php');
$username = 'Rando';
$password = 'rando';
$host = 'localhost';
$dbname = 'sem_databaze';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$stmt = $pdo->prepare("SELECT * FROM autor");
$stmt->execute();
$result = $stmt -> fetchAll();


?>
<main>
    <link rel="stylesheet" type="text/css" href="css/test1.css">
    <div class="center-wrapper">
        <div>
            <h2>Authors</h2>
            <p>
                <?php foreach( $result as $row ) { ?>
            <p>  <?php echo $row['nick'];?>
                     <?php echo $row['idAutor']; ?> </p>
                 <?php } ?>

            </p>
        </div>
    </div>
</main>
<?php

include('elementals/footer.html')


?>