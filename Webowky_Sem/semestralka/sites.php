<?php
include 'elementals/header.php';
include 'Connection.php';

$pdo = Connection::getPdoInstance();
$stmt = $pdo->prepare("SELECT * FROM stranka");
$stmt->execute();
$result = $stmt -> fetchAll();

?><link rel="stylesheet" type="text/css" href="css/test1.css">
    <link rel="stylesheet" type="text/css" href="../css/test2.css">
    <main>

        <div class="center-wrapper">
            <div>
                <h2>Sites</h2>
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Rating</th>
                        <th>Brief Introduction</th>

                    </tr>

                    <?php foreach( $result as $row ) {
                        if($row["id_Stranka"] != 0){
                        ?>
                        <tr>   <td> <a href="<?php echo $row['link']?>"><?php echo $row['jmeno'];?>
                                </a>   </td>
                            <td><?php echo $row['hodnoceni'] ?></td>
                            <td><?php echo $row['popisek'] ?></td></tr>
                    <?php }
                    } ?>

                </table>
            </div>
        </div>
    </main>
<?php
include 'elementals/footer.html';
?>