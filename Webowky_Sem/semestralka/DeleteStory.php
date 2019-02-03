<?php
/**
 * Created by PhpStorm.
 * User: Vojta
 * Date: 21/01/2019
 * Time: 12:39
 */
include 'Connection.php';
class DeleteStory
{
    private function __construct()
    {
    }

    static function deleteStory($paramId) : void
    {
        $conn = Connection::getPdoInstance();
        $stmt = $conn->prepare("DELETE FROM tagstory WHERE fkStory = $paramId");
        $stmt->execute();
        $stmt = $conn->prepare("DELETE FROM linkstorystra WHERE idStor = $paramId");
        $stmt->execute();
        $stmt = $conn->prepare("DELETE FROM story WHERE idStory = $paramId");
        $stmt->execute();
      //  header("location:" . "stories.php");
    }

    static function deleteStoryInner($paramId) : void
    {
        $conn = Connection::getPdoInstance();
        $stmt = $conn->prepare("DELETE FROM tagstory WHERE fkStory = $paramId");
        $stmt->execute();
        $stmt = $conn->prepare("DELETE FROM linkstorystra WHERE idStor = $paramId");
        $stmt->execute();
        $stmt = $conn->prepare("DELETE FROM story WHERE idStory = $paramId");
        $stmt->execute();

    }
    static function deleteSite($paramId) : void
    {
        $conn = Connection::getPdoInstance();
        $stmt = $conn->prepare("DELETE FROM linkautstr WHERE idStranky = $paramId");
        $stmt->execute();
        $stmt = $conn->prepare("DELETE FROM linkstorystra WHERE idStranky = $paramId");
        $stmt->execute();
        $stmt = $conn->prepare("DELETE FROM stranka WHERE id_Stranka = $paramId");
        $stmt->execute();

    }

    static function updateHodnoceni($id,$table):void
    {
        if($table == "story") {
            $conn = Connection::getPdoInstance();
            $stmt = $conn->prepare("select IFNULL(AVG(review.hodnoceni ),0) from review where review.fkStoryid = $id ");
            $stmt->execute();
            $sum = $stmt->fetchColumn();
            $stmt = $conn->prepare("update story set story.hodnoceni = $sum where idStory = $id");
            $stmt->execute();
        }else{
            $conn = Connection::getPdoInstance();
            $stmt = $conn->prepare("select IFNULL(AVG(review.hodnoceni),0) from review where review.fkAutorid = $id ");
            $stmt->execute();
            $sum = $stmt->fetchColumn();
            $stmt = $conn->prepare("update autor set autor.hodnoceni = $sum where idAutor = $id");
            $stmt->execute();
        }
    }

    static function deleteReview($paramIdUser, $paramIdVar, $var) : void
    {
        $conn = Connection::getPdoInstance();
        if($var == "story"){
            $stmt = $conn->prepare("DELETE FROM review WHERE fkUzivatelid = $paramIdUser and fkStoryid = $paramIdVar");
            $stmt->execute();
            //nickname=<?php echo $row['nick']
            header("location:" . "stories.php?storyId=$paramIdVar");
        }
        else{
            $stmt = $conn->prepare("DELETE FROM review WHERE fkUzivatelid = $paramIdUser and fkAutorid = $paramIdVar");
            $stmt->execute();
            header("location:" . "authors.php?idAutoria=$paramIdVar");
        }



    }
    static function deleteReview2($var,$paramIdVar,$var1) : void
    {
        $conn = Connection::getPdoInstance();
        if($var1 == "story"){
            $stmt = $conn->prepare("DELETE FROM review WHERE idReview = $var");
            $stmt->execute();
            //nickname=<?php echo $row['nick']
            self::updateHodnoceni($paramIdVar,$var1);
            header("location:" . "storyDisplay.php?storyId=$paramIdVar");
        }
        else{
            $stmt = $conn->prepare("DELETE FROM review WHERE idReview = $var");
            $stmt->execute();
            self::updateHodnoceni($paramIdVar,$var1);
            header("location:" . "authorDisplay.php?idAutoria=$paramIdVar");
        }



    }

    static function deleteAutor($paramId) : void
    {
        $conn = Connection::getPdoInstance();
        $stmt = $conn->prepare("SELECT idStory from story where fk_Autorid = $paramId");
        $stmt->execute();
        $resStory = $stmt->fetchAll();

       foreach($resStory as $res ){
           $idTemp = $res["idStory"];
           $conn = Connection::getPdoInstance();
           $stmt = $conn->prepare("DELETE FROM tagstory WHERE fkStory = $idTemp");
           $stmt->execute();

           $stmt = $conn->prepare("DELETE FROM linkstorystra WHERE idStor = $idTemp");
           $stmt->execute();
           $stmt = $conn->prepare("DELETE FROM story WHERE idStory = $idTemp");
           $stmt->execute();


    }
        $stmt = $conn->prepare("delete from linkautstr where idAutora = $paramId");
        $stmt->execute();
        $stmt = $conn->prepare("DELETE FROM review WHERE fkAutorid = $paramId");
        $stmt->execute();
        $stmt = $conn->prepare("Delete from autor where idAutor = $paramId ");
        $stmt->execute();
        header("location:" . "authors.php");
    }
    /*static function createStory($paramIdUser, $paramIdVar, $var) : void
    {
        $conn = Connection::getPdoInstance();
        if($var == "story"){
            $stmt = $conn->prepare("DELETE FROM review WHERE fkUzivatelid = $paramIdUser && fkStoryid = $paramIdVar");
            $stmt->execute();
            header("location:" . "stories.php");
        }
        else{
            $stmt = $conn->prepare("DELETE FROM review WHERE fkUzivatelid = $paramIdUser && fkAutorid = $paramIdVar");
            $stmt->execute();
            header("location:" . "authors.php");
        }



    }*/
}