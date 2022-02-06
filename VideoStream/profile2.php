<?php
session_start();
require_once "config.php";
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
    header("location: login.php");
}
$chname=$_GET['name'];
$sql = "SELECT * FROM `followers` WHERE `user` = '$chname'";
    $result = mysqli_query($conn, $sql);
    $cou=0;
    while($row = mysqli_fetch_assoc($result)){
        $cou=$cou+1;
    }
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $currentUserName=$_SESSION['username'];
    $sql = "SELECT * FROM `followers` WHERE `otherUsers` = '$currentUserName'";
    $result = mysqli_query($conn, $sql);
    $c=0;
    while($row = mysqli_fetch_assoc($result)){
        $c=$c+1;
    }
    if($c==0)
    {
        $sql = "INSERT INTO `followers` (`user`, `otherUsers`) VALUES ('$chname', '$currentUserName')";
        $result = mysqli_query($conn, $sql);
    }
    
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="profile.css">
    <title>Profile</title>
</head>

<body>

    <body>
    <?php 
          $sql = "SELECT * FROM `users` WHERE `username` = '$chname'";
          $result = mysqli_query($conn, $sql);
          
          while($row = mysqli_fetch_assoc($result)){
            echo '<div class="container mt-5">
            <div class="row d-flex justify-content-center">
                <div class="col-md-7">
                    <div class="card p-3 py-4">
                        <div class="text-center"> <img
                                src="b.jpg"
                                width="250" class="rounded-circle"> </div>
                        <div class="text-center mt-3 gap-3">
                        <form action="" method="post">
                        <button class="bg-secondary p-1 px-4 rounded text-white" id="followButton">Add Following</button>
                        </form>
                        <h5 class="text-white mt-5 mb-4 gap-sm-5">'. $row['username'] . '</h5>
                        <h5 class="text-white">'. $row['email'] . '</h5>
                            <div class="px-4 mt-1">
                                <p class="text-white-50 gap-3 text-md-start" style="color: aliceblue;margin-bottom: 0;">
                                    Total Followers: '.$cou.'
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
        } 
    ?>
    
    </body>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>

</html>