<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
    header("location: login.php");
}
else
{
	require_once "config.php";
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$vid = $_POST['vid1'];
	$img = $_POST['img1'];
	$title=$_POST['title1'];
	$Chname=$_SESSION['username'];
	$id=$_SESSION["id"];
	$sql = "INSERT INTO `video` (`title`, `video`, `image`, `chname`, `userid`) VALUES ('$title', '$vid', '$img', '$Chname', '$id')";
	
  	$result = mysqli_query($conn, $sql);
  	if($result)
	{ 
      $insert = true;
  	}
  	else
	{
      echo "The record was not inserted successfully because of this error ---> ". mysqli_error($conn);
  	} 
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
  <link rel="stylesheet" href="upload.css">
  <title>Upload</title>
</head>

<body>
	
  <div class="frame">
    <div class="center">
      <div class="title">
        <h1>Drop file to upload</h1>
      </div>

      <div class="dropzone">
        <img src="http://100dayscss.com/codepen/upload.svg" class="upload-icon" />
        <p>Video</p>
        <input id="input1" class="upload-input"  name="" type="file"/>
      </div>
      
      <br>
      <br>
      <div class="dropzone">
        <img src="http://100dayscss.com/codepen/upload.svg" class="upload-icon" />
        <p>Thunmnail:</p>
        <input id="input2" class="upload-input"  name="" type="file"/>
      </div>

      <button type="button" id="button1" class="btn" name="uploadbutton">Upload</button>
	  <form  action="" method="post">
	  <input type="hidden" name="img1" id="img">
	  <input type="hidden" name="vid1" id="vid">
	  <input type="hidden" name="title1" id="title">
	  <button id="button">Submit</button>
      <form>
      <!-- <button type="button" id="button2" class="btn" name="uploadbutton">Thunmnail Upload</button> -->
    </div>
  </div>
  <!-- original pen: https://codepen.io/roydigerhund/pen/ZQdbeN  -->

  <!-- NO JS ADDED YET -->

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
    <script src="https://www.gstatic.com/firebasejs/8.5.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.5.0/firebase-storage.js"></script>

  <script>
    // Your web app's Firebase configuration
    const firebaseConfig = {
      apiKey: "AIzaSyCNlKDzfHfbUVgUkxNq6DjFAdutu1Wqxbk",
      authDomain: "video-9acd2.firebaseapp.com",
      projectId: "video-9acd2",
      databaseURL: "https://video-9acd2.firebaseio.com",
      storageBucket: "video-9acd2.appspot.com",
      messagingSenderId: "338981609870",
      appId: "1:338981609870:web:bde4a2995c51cb3006c4df",
      measurementId: "G-5SJWKFK15H"
    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
  </script>

  <script>
    // select BUTTOM
const btn = document.getElementById('button1')

var url1;
var url2;

$('#input1').on('change', function(evt) {
		Totalsize=this.files[0].size;
		
		console.log(Totalsize);
  });

// ADD CLICK LISTENER TO THE BUTTON WE SELECTED
btn.addEventListener('click',e =>{
	// GET FILE FROM THE  FILE INPUT 
    const file = document.querySelector('input').files[0]
	var s=document.querySelector('input').files[0].name;
	console.log(document.querySelector('input').files[0].size)
	s = s.substring(0, s.indexOf('.'));
	document.getElementById("title").value=s;
	console.log(s);
	if(document.querySelector('input').files[0].size<=31457280)
	{
		// MAKE A REFERNCE TO FIREBASE .
	const storageRef = firebase.storage().ref()
	// MAKE A CHILD REFERENCE . WE ARE MAKING A FOLDER  NAMED IMAGES AND ADDING THE FILE THE USER PICKED TO FIREBASE
const final =storageRef.child(`Videos/`+s)
// THIS UPLOAD THE FILE.. WE STORE IT IN A CONST TO DOWNLOAD THE THE FILE AND E.C.T
	const task = final.put(file)

task.on('state_changed',
		// PROGRESS FUNCTION
		function progress(progress){

			console.log(progress.bytesTransferred / progress.totalBytes *100)
		},  
		function error(err){
			console.log('There was An Err ' + err)
		},
		 function completed(){
		 	final.getDownloadURL()
		 	// RETURN A PROMISE
		 	.then(url=>{
		 		// SELECTING THE BODY AND APPENDING AN IMG TAG WITH  THE URL
				 //document.querySelector('body').innerHTML =`<h1>${url}</h1>`
				 url1=url;
				 document.getElementById("vid").value=url1;
		 	})
		 }

		)
	}
	else
	{
		alert("File size should be less than 30 mb")
	}
//image
	const file1 = document.getElementById('input2').files[0]
	console.log(document.getElementById('input2').files[0])
	var s=document.getElementById('input2').files[0].name;
	console.log(document.getElementById('input2').files[0].size)
	s = s.substring(0, s.indexOf('.'));
	console.log(s);
	const storageRef = firebase.storage().ref()
	// MAKE A CHILD REFERENCE . WE ARE MAKING A FOLDER  NAMED IMAGES AND ADDING THE FILE THE USER PICKED TO FIREBASE
const final =storageRef.child(`Image/`+s)
// THIS UPLOAD THE FILE.. WE STORE IT IN A CONST TO DOWNLOAD THE THE FILE AND E.C.T
	const task = final.put(file1)

task.on('state_changed',
		// PROGRESS FUNCTION
		function progress(progress){

			console.log(progress.bytesTransferred / progress.totalBytes *100)
		},  
		function error(err){
			console.log('There was An Err ' + err)
		},
		 function completed(){
		 	final.getDownloadURL()
		 	// RETURN A PROMISE
		 	.then(url=>{
		 		// SELECTING THE BODY AND APPENDING AN IMG TAG WITH  THE URL
				 //document.querySelector('body').innerHTML =`<h1>${url}</h1>`
				 url2=url;
				 
				 document.getElementById("img").value=url2;
		 	})
		 }

		)
})











/*// select BUTTOM
const btn2 = document.getElementById('button2')

$('#input2').on('change', function(evt) {
		Totalsize=this.files[0].size;
		
		console.log(Totalsize);
  });

// ADD CLICK LISTENER TO THE BUTTON WE SELECTED
btn2.addEventListener('click',e =>{
	// GET FILE FROM THE  FILE INPUT 
	const file = document.getElementById('input2').files[0]
	console.log(document.getElementById('input2').files[0])
	var s=document.getElementById('input2').files[0].name;
	console.log(document.getElementById('input2').files[0].size)
	s = s.substring(0, s.indexOf('.'));
	console.log(s);
	if(document.getElementById('input2').files[0].size<=31457280)
	{
		// MAKE A REFERNCE TO FIREBASE .
	const storageRef = firebase.storage().ref()
	// MAKE A CHILD REFERENCE . WE ARE MAKING A FOLDER  NAMED IMAGES AND ADDING THE FILE THE USER PICKED TO FIREBASE
const final =storageRef.child(`Image/`+s)
// THIS UPLOAD THE FILE.. WE STORE IT IN A CONST TO DOWNLOAD THE THE FILE AND E.C.T
	const task = final.put(file)

task.on('state_changed',
		// PROGRESS FUNCTION
		function progress(progress){

			console.log(progress.bytesTransferred / progress.totalBytes *100)
		},  
		function error(err){
			console.log('There was An Err ' + err)
		},
		 function completed(){
		 	final.getDownloadURL()
		 	// RETURN A PROMISE
		 	.then(url=>{
		 		// SELECTING THE BODY AND APPENDING AN IMG TAG WITH  THE URL
		 		document.querySelector('body').innerHTML =`<h1>${url}</h1>`
		 	})
		 }

		)
	}
	else
	{
		alert("File size should be less than 30 mb")
	}


})*/
  </script>
</body>

</html>