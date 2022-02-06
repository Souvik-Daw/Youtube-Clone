<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
    header("location: login.php");
}
require_once "config.php";
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    echo "clicked";
    $chname = trim($_POST['chname']);

    $currentUserName=$_SESSION['username'];
    $sql = "SELECT * FROM `like` WHERE `otherUsers` = '$currentUserName'";
    $result = mysqli_query($conn, $sql);
    $c=0;
    while($row = mysqli_fetch_assoc($result)){
        $c=$c+1;
    }
    if($c==0)
    {
        $sql = "INSERT INTO `like` (`user`, `otherUsers`) VALUES ('$chname', '$currentUserName')";
        $result = mysqli_query($conn, $sql);
    }

    header("Location: http://localhost/VideoStream/welcome.php");
    die();
}

?>