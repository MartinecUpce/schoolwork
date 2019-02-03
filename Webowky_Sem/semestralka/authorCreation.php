<?php
include 'elementals/header.php';
include 'DeleteStory.php';

if(empty($_SESSION["user_id"])) {
    header("location:" ."about2.php");
    exit();
}
$nick = "";
$info = "";
$link = "";
$conn = Connection::getPdoInstance();


?>
    <main>
        <link rel="stylesheet" type="text/css" href="css/test1.css">
        <link rel="stylesheet" type="text/css" href="../css/test2.css">
        <div class="center-wrapper">

            <form action="" method="post">
                <br>
                <label>link to home site:</label><select name="select_create_site">
                    <?php
                    $conn = Connection::getPdoInstance();
                    $stmt1 = $conn->prepare("Select * from stranka");
                    $result1 = $stmt1->execute();
                    $result1 = $stmt1 ->fetchAll();
                    $p = 0;
                    foreach($result1 as $row1) { if(p ==0){?>

                        <option value="<?=$row1["id_Stranka"];?>", selected="selected"><?=$row1["jmeno"];?></option>
                        <?php $p = 1;  }else {
                        ?>

                        <option value="<?=$row1["id_Stranka"];?>"><?=$row1["jmeno"];?></option>
                        <?php
                    }}
                    ?>
                </select><br>
                <label>Nick: </label><input type="text" name="nick" value="<?php echo $nick; ?>">

                <br>
                <label>Info:</label>  <textarea name="info" rows="5" cols="40" maxlength="1000"><?php echo $info; ?></textarea>

                <br>
                <label>Link: </label><input type="text" name="link" value="<?php echo $link; ?>">

                <br>

                <input type="submit" name="submit2" value="Submit new author"/>
            </form>


<?php
//implementation of form, taken from W3 school

if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["submit2"])) {
    if (empty($_POST["nick"])) {
        echo "<script type='text/javascript'>alert('Empty nick');</script>";
    } else if (empty($_POST['link'])) {
        echo "<script type='text/javascript'>alert('Empty link');</script>";
    } else if (!isset($_POST['select_create_site'])) {
        echo "<script type='text/javascript'>alert('Improperly Selected boxes');</script>";
    }

    else {
        $nick = $_POST['nick'];
        if (!empty($_POST['info'])) {
            $info = $_POST['info'];
        }

        $link = $_POST['link'];


        $choice3 = $_POST['select_create_site'];
        $conn = Connection::getPdoInstance();
        try{
            $stmt1 = $conn->prepare("insert into autor (nick,info,approved,hodnoceni) values (:nick,:info, 0,0)");
            $stmt1->bindParam(':nick', $_POST["nick"]);
            $stmt1->bindParam(':info', $_POST["info"]);
            $result1 = $stmt1->execute();

            $last_id = $conn->lastInsertId();

            $stmt1 = $conn->prepare("insert into linkautstr (idStranky,idAutora,linked) values ('$choice3','$last_id',:link)");
            $stmt1->bindParam(':link', $_POST['link']);
            $stmt1->execute();



            echo "<script type='text/javascript'>window.location.href = 'authors.php';</script>";}
            catch(PDOException $ex){
            echo $ex;
            echo "<script type='text/javascript'>alert('Author like that already exists');</script>";
        }}}
        ?>







            <div>

            </div>
        </div>
    </main>
<?php
include 'elementals/footer.html';
?>