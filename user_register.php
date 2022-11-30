<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
	<style>
		body{
			background-color: #e3e5e8;
      align-items: center;
		}
		form{
			background-color: #fff;
			margin-top: 40px;
			margin-left: 300px;
			margin-right: 300px;
			padding: 30px;
			box-shadow: 10px 10px 8px 10px #888888;
		}
	</style>
	<title>Register</title>
</head>
<body>
	<div class="container">
    <?php
          if(isset($_POST["submit"])){
            $fullName=$_POST["name"];
            $email=$_POST["email"];
            $contact=$_POST["phone_no"];
            $password=$_POST["password"];
            $confirmpass=$_POST["confirmpass"];

            $errors= array();
            
            if(empty($fullName) OR empty($email) OR empty($contact) OR empty($password) OR empty($confirmpass)){
              array_push($errors,"All fields are required");
            }

            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
              array_push($errors,"Email is not valid");
            }

            if(strlen($password)<8){
              array_push($errors,"Password must be at least of 8 length");
            }

            if($password !== $confirmpass)
            {
              array_push($errors,"Password doesn't match");
            }
            
            require_once "database.php";
            $sql="SELECT * from users WHERE email='$email'";
            $result=mysqli_query($conn,$sql);
            $rowCount=mysqli_num_rows($result);
            if($rowCount>0)
            {
              array_push($errors,"email alreay exit");
            }
            if(count($errors)>0){
              foreach($errors as $errors){
                echo "<div class='alert alert-danger'>$errors</div>";
              }
            }
            else{
              //require_once "database.php";
              $sql= "INSERT INTO users(Name,email,password,phone_no) VALUES (?,?,?,?)";
              $stmt=mysqli_stmt_init($conn);
              $preparestmt=mysqli_stmt_prepare($stmt,$sql);
              if($preparestmt){
                mysqli_stmt_bind_param($stmt,"sssi",$fullName,$email,$password,$contact);
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>Registered Successfully</div>";
              }
              else{
                die("Something went wrong");
              }
            }
          }
    ?>
    <p class="fs-3" style="text-align: center; margin-top: 30px; color: #0e1a35;"><b>Garbage</b> Management System</p>
    <form method="POST">
    <div class="mb-3">
      <label for="exampleInputName" class="form-label">Full Name</label>
      <input type="text" class="form-control" id="exampleInputName" name="name" required>
    </div>
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Email address</label>
      <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" required>
      <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>
    <div class="mb-3">
      <label for="exampleInputNumber" class="form-label">Phone Number</label>
      <input type="number" class="form-control" id="exampleInputNumber"name="phone_no"  required>
    </div>
    <div class="mb-3">
      <label for="exampleInputPassword1" class="form-label">Password</label>
      <input type="password" class="form-control" id="exampleInputPassword1" name="password" required>
    </div>
    <div class="mb-3">
      <label for="exampleInputPassword2" class="form-label">Confirm Password</label>
      <input type="password" class="form-control" id="exampleInputPassword2" name="confirmpass" required>
    </div>
    <button type="submit" class="btn btn-primary" name="submit">Sign Up</button>
    <br>
    <br>
    Already Registered? <a href="user_login.php">Login</a>
  </form>
	</div>
</body>
</html>