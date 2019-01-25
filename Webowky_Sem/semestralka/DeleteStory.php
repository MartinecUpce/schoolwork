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
        header("location:" . "stories.php");
    }

    static function deleteReview($paramIdUser, $paramIdVar, $var) : void
    {
        $conn = Connection::getPdoInstance();
        if($var == "story"){
            $stmt = $conn->prepare("DELETE FROM review WHERE fkUzivatelid = $paramIdUser && fkStoryid = $paramIdVar");
            $stmt->execute();
            //nickname=<?php echo $row['nick']
            header("location:" . "stories.php?storyId=$paramIdVar");
        }
        else{
            $stmt = $conn->prepare("DELETE FROM review WHERE fkUzivatelid = $paramIdUser && fkAutorid = $paramIdVar");
            $stmt->execute();
            header("location:" . "authors.php?idAutoria=$paramIdVar");
        }



    }

    static function deleteAutor($paramId) : void
    {
        $conn = Connection::getPdoInstance();
        $stmt = $conn->prepare("SELECT idStory from story where fk_Autorid = $paramId");
        $stmt->execute();
        $resStory = $stmt->fetchColumn();
        foreach($resStory as $res ){
            self::deleteStory($res["idStory"]);
    }
        $stmt = $conn->prepare("delete from linkautstr where idAutora = $paramId");
        $stmt->execute();
        $stmt = $conn->prepare("DELETE FROM review WHERE fkAutorid = $paramId");
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