<?php
/**
 * Created by PhpStorm.
 * User: Vojta
 * Date: 02/02/2019
 * Time: 14:56
 */


include 'elementals/header.php';
include 'DeleteStory.php';


$varId = $_GET["idAuthor"];

$conn = Connection::getPdoInstance();

if(empty($_GET["idAuthor"])) {
    header("location:" ."authors.php");
    exit();
}
if(isset($_POST["cancel"])){
    echo "<script type='text/javascript'>window.location.href = 'stories.php';</script>";
    exit();

}
if(isset($_POST["addLink"])){
    if(empty($_POST["linkAdd"])){
        echo "<script type='text/javascript'>alert('Cannot have entirely empty link');</script>";
    }
    else{
        try{
            $choiceLinkAdd = $_POST['select_add_site'];
            $stmt1 = $conn->prepare("insert into linkautstr(idStranky,idAutora,linked) values('$choiceLinkAdd','$varId',:link)" );
            $stmt1->bindParam(':link', $_POST['linkAdd']);
            $stmt1->execute();
        }catch(PDOException $ex){

            echo "<script type='text/javascript'>alert('Cannot have two links to any, even default site');</script>";
        }
    }

}
if(isset($_POST["removeLink"])){


    try{
        $choiceLinkRemove = $_POST['select_remove_site'];
        $stmt1 = $conn->prepare("delete from linkautstr where idStranky = '$choiceLinkRemove' and idAutora = $varId");

        $stmt1->execute();
    }catch(PDOException $ex){

        echo "<script type='text/javascript'>alert('Cannot Delete for some reason');</script>";
    }


}
if(isset($_POST["changeNick"])){
    if(empty($_POST["editNick"])){
        echo "<script type='text/javascript'>alert('Cannot have empty nick');</script>";
    }
    else{
        try{

            $stmt1 = $conn->prepare("update autor set nick=:nick where idAutor = $varId" );
            $stmt1->bindParam(':nick', $_POST['editNick']);
            $stmt1->execute();
        }catch(PDOException $ex){

            echo "<script type='text/javascript'>alert('Cannot have two autors with the same name');</script>";
        }
    }
}
if(isset($_POST["changeInfo"])){
    if(empty($_POST["editInfo"])){
        echo "<script type='text/javascript'>alert('Cannot have entirely empty info');</script>";
    }
    else{
        try{

            $stmt1 = $conn->prepare("update autor set info=:info where idAutor = $varId" );
            $stmt1->bindParam(':info', $_POST['editInfo']);
            $stmt1->execute();
        }catch(PDOException $ex){

            echo "<script type='text/javascript'>alert('Some doodlerydoody just happened $ex');</script>";
        }
    }
}

$stmt = $conn->prepare("select * from autor where idAutor = $varId");
$stmt->execute();
$res = $stmt->fetch();
$nick = $res["nick"];
$info = $res["info"];

?>
    <main>
        <link rel="stylesheet" type="text/css" href="css/test1.css">
        <link rel="stylesheet" type="text/css" href="../css/test2.css">
        <div class="center-wrapper">
        <h2 align="center">Author edit</h2>
            <form action ="" method="post">
                <label>Select site for link: </label>
                <select name="select_add_site">
                    <?php
                    $conn = Connection::getPdoInstance();
                    $stmt1 = $conn->prepare("Select * from stranka");
                    $result1 = $stmt1->execute();
                    $result1 = $stmt1 ->fetchAll();
                    $p = 0;
                    foreach($result1 as $row1) { if($p ==0){?>

                        <option value="<?=$row1["id_Stranka"];?>", selected="selected"><?=$row1["jmeno"];?></option>
                        <?php $p = 1;  }else {
                        ?>

                        <option value="<?=$row1["id_Stranka"];?>"><?=$row1["jmeno"];?></option>
                        <?php
                    }}
                    ?>
                </select>

                <label>Add Link: </label><input type="text" name="linkAdd" value="">

                <br>
                <input type="submit" name="addLink" value="Add link"/>


            </form>
            <br>
            <form action="" method="post">
                <label>Nick: </label><input type="text" name="editNick" value="<?php echo $nick; ?>">
                <input type="submit" name="changeNick" value="Change nick"/>

            </form>
            <br>
            <form action="" method="post">
            <br>
                <label>Info:</label>  <textarea name="editInfo" rows="5" cols="40" maxlength="1000"><?php echo $info; ?></textarea>
                <br>
                <input type="submit" name="changeInfo" value="Change info"/>

            </form>
            <br>
                <form action ="" method="post">
                    <label>Remove existing link: </label>
                    <select name="select_remove_site">
                        <?php
                        $conn = Connection::getPdoInstance();
                        $stmt1 = $conn->prepare("Select stranka.id_Stranka, stranka.jmeno from stranka join linkautstr on stranka.id_Stranka = linkautstr.idStranky where linkautstr.idAutora = $varId");
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
                    </select>



                    <br>

                    <input type="submit" name="removeLink" value="Remove link"/>
                    <input type="submit" name="cancel" value="Leave"/>


                </form>
                <br>
                <br>
                <br>
                <br>









            <div>

            </div>
        </div>
    </main>
<?php
include 'elementals/footer.html';
?>