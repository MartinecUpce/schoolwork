<?php
/**
 * Created by PhpStorm.
 * User: Vojta
 * Date: 07/01/2019
 * Time: 18:17
 */
include 'elementals/header.php';
$username = 'Rando';
$password = 'rando';
$host = 'localhost';
$dbname = 'sem_databaze';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$stmt = $pdo->prepare("SELECT * FROM story");
//$stmt = $pdo->prepare("SELECT DISTINCT storyName FROM story JOIN tagstory t on story.idStory = t.fkStory join tag on t.fkTag = tag.idTag");

$stmt->execute();
$result = $stmt -> fetchAll();
?>
    <main>
        <link rel="stylesheet" type="text/css" href="css/test1.css">
        <link rel="stylesheet" type="text/css" href="../css/test2.css">
        <div class="center-wrapper">
            <div>
                <h2>Bunch of stories</h2>
                <table>
                    <tr>
                        <th>Name of story</th>
                        <th>Rating</th>
                        <th>Brief Summary(if present)</th>

                    </tr>

                    <?php foreach( $result as $row ) {
                       if($row['approved'] !=0){
                        ?>

                           <tr>
                               <td> <a href="./storyDisplay.php?storyId=<?php echo $row['idStory']?>">
                                       <?php echo $row['storyName']?>
                                   </a>   </td>
                               <td><?php echo $row['hodnoceni'] ?></td>
                               <td><?php echo $row['storySummary'] ?></td>
                           </tr>

                    <?php } } ?>
                </table>
            </div>
        </div>
    </main>
<?php
include 'elementals/footer.html';
?>