<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
    header("location: login.php");
}
require_once "config.php";

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
    <link rel="stylesheet" href="home.css">
    <script src="https://kit.fontawesome.com/be0028ee79.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Home</title>
    
</style>
</head>

<body>
    <section id="navbar">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Youtube</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="upload.php">Upload</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <?php echo '<a class="nav-link" href="profile.php?name='. $_SESSION['username'] . '"> <img src="https://img.icons8.com/metro/26/000000/guest-male.png">' ?> <?php echo "Welcome ". $_SESSION['username']?></a>
                        </li>
                    </ul>
            </div>
        </nav>
    </section>
    <section id="search">
        <form class="example" action="/action_page.php">
            <input type="text" placeholder="Search.." name="search">
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
    </section>
    <section id="video">
        <?php 
          $sql = "SELECT * FROM `video`";
          $result = mysqli_query($conn, $sql);
          $sno = 0;
          while($row = mysqli_fetch_assoc($result)){
            
            $chname=$row['chname'];
            $sql1 = "SELECT * FROM `like` WHERE `user` = '$chname'";
                $result1 = mysqli_query($conn, $sql1);
                $cou=0;
                while($row1 = mysqli_fetch_assoc($result1)){
                    $cou=$cou+1;
                }

              $full=$row['title'];
              if(strlen($row['title'])>=25)
              {
                $titleF=substr($row['title'],0,25)."...";
              }
              else
              {
                  $titleF=$row['title'];
              }
            
            echo '<div style="margin: 15px;">
            <video id="'. $row['id'] . '" class="video-js" controls preload="auto"  width="300" height="300" poster='. $row['image'] .' 
                data-setup="{}">
                <source
                    src='. $row['video'] . '
                    type="video/mp4" />
                <p class="vjs-no-js">
                    To view this video please enable JavaScript, and consider upgrading to a
                    web browser that
                    <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                </p>
            </video>
            <p id="'. $row['id'] . 'view">view</p>
            <div  style="display: flex; justify-content: space-between;">
            
            <p style="margin:0"><b>'. $titleF. '</b></p>
            <form action="like.php" method="post" role="form" target="">
                <input type="hidden" id="chname" name="chname" value="'.$row['chname'].'">
                <button type="submit"><i class="fas fa-thumbs-up">'.$cou.'</i></button>
            </form>
            </div>
            
            <p style="margin: 0;"><a href="profile2.php?name='. $row['chname'] . '">'. $row['chname'] . '</a></p>
            </div>';
        } 
          ?>
        
    </section>
    <form  id="myForm" action="" method="post">
    <input type="hidden" id="videoid" name="videoid">
    </form>
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
        <script>

        
    </script>
    
</body>

</html>
