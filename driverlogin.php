<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
	<style type="text/css">
		body{
			margin: 0px;
			padding: 0px;
			background-image: url('backgroundimage.jpg');
			background-size: cover;
		}
		form{
			background-color: #fff;
			margin-left: 30em;
			margin-right: 10em;
			margin-top: 6em;
			padding: 40px;
			box-shadow: 10px 10px 8px 10px #888888;

		}
	</style>
</head>
<body>
	<div class="container">
		
		<form method="POST">
			<h1>Driver Login</h1>
			<br>
		  <div class="mb-3">
		    <label for="exampleInputEmail1" class="form-label">Email address</label>
		    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
		    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
		  </div>
		  <div class="mb-3">
		    <label for="exampleInputPassword1" class="form-label">Password</label>
		    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
		  </div>
		  <button type="submit" class="btn btn-primary" name="Login">Submit</button>
		</form>
		<?php
		if(isset($_POST["Login"])){
            $email=$_POST["email"];
            $password=$_POST["password"];

           
              require_once "database.php";
			  session_start();
			
              $sql= "SELECT * FROM driver where email='$email'";
			  $result=mysqli_query($conn,$sql);
			  $user=mysqli_fetch_array($result,MYSQLI_ASSOC);
              if($user){
				if($password!==$user["password"]){
                echo "<div class='alert alert-danger'>Wrong password</div>";
				}
				else{
					$_SESSION['driver_email']=$email;
					$_SESSION['driver_id']=$user["DriverID"];
					$_SESSION['driver_name']=$user["DriverName"];
					header("Location: driverdashboard.php");
					die();
				}
              }
              else{
				echo "<div class='alert alert-danger'>email not registered</div>";
                die();
              }
            }
		?>

	</div>
</body>
</html>