
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" integrity="sha384-xeJqLiuOvjUBq3iGOjvSQSIlwrpqjSHXpduPd6rQpuiM3f5/ijby8pCsnbu5S81n" crossorigin="anonymous">
    <style>
      .sidebar {
          margin: 0;
          padding: 30px;
          width: 300px;
          background-color: #f1f1f1;
          position: fixed;
          height: 100%;
          overflow: auto;
        }

        .sidebar a {
          display: block;
          color: whitesmoke;
          padding: 16px;
          text-decoration: none;
        }

        .sidebar a.active {
          background-color: #4CAF50;
          color: white;
        }

        .sidebar a:hover:not(.active) {
          background-color: #555;
          color: white;
        }


        div.content {
          margin-top: 60px;
          margin-left: 200px;
          padding: 1px 16px;
          height: 1000px;
        }

        @media screen and (max-width: 700px) {
          .sidebar {
            width: 100%;
            height: auto;
            position: relative;
          }
          .sidebar a {float: left;}
          div.content {margin-left: 0;}
        }

        @media screen and (max-width: 400px) {
          .sidebar a {
            text-align: center;
            float: none;
          }
        }
        .navbar {
          overflow: hidden;
          position: fixed;
          top: 0;
          width: 100%;
          height: 60px;
        }

      </style>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg bg-primary">
      <div class="container-fluid">
        <a class="navbar-brand fw-bold" style="color: white; padding-left: 20px;" href="#">Garbage Management System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <!-- <li class="nav-item">
              <a class="nav-link"  style="color: white;" href="#"><i class="bi bi-house-fill"></i>/Dashboard</a>
            </li> -->
          </ul>
          <a class="nav-link d-flex" style="color: white; padding-right: 20px;"><i class="bi bi-person-fill"></i></a>
        </div>
      </div>
    </nav>
    <div class="sidebar" style="background-color: #0e1a35; color: white;">
      <div style="text-align:center;">
        <img src="assests/download-removebg-preview.png" class="rounded" alt="user_image">
        <p class="text-uppercase">Admin</p>
        <p>Email</p>
      </div>
      <hr>
      <a href="index.php"><i class="bi bi-house-door mx-2"></i>Dashboard</a>
      <a href="driver.php"><i class="bi bi-person mx-2"></i>Driver</a>
      <a href="viewcomplains.php"><i class="bi bi-search mx-2"></i>View complains</a>
      <a href="segregation.php"><i class="bi bi-person mx-2"></i>Segregation</a>
      <a href="assign.php"><i class="bi bi-person mx-2"></i>Assign to Driver</a>
    </div>
    <div class="content" style="background-color: #edeff0;">
      <span class="d-block" style="background-color: #a1a5ad;margin-left: 80px; padding: 10px; padding-left: 30px;"><p class="fs-4">Dashboard</p></span>
      <div class="container p-4" style="margin-left: 200px; margin-top: 50px;">
        <p class="fs-5" style="padding-bottom: 20px;"><b>Add Driver</b></p>
      <hr>
        <div class="container">
        <?php
                if(isset($_POST["submit"])){
                  
                  require_once "database.php";
                  $fullName=$_POST["name"];
                  $email=$_POST["email"];
                  $contact=$_POST["phone_no"];

                  $errors= array();
                  
                  if(empty($fullName) OR empty($email) OR empty($contact)){
                    array_push($errors,"All fields are required");
                  }
      
                  if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                    array_push($errors,"Email is not valid");
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
                    $sql= "INSERT INTO driver(DriverName,email,Contact) VALUES (?,?,?)";
                    $stmt=mysqli_stmt_init($conn);
                    $preparestmt=mysqli_stmt_prepare($stmt,$sql);
                    if($preparestmt){ 
                      mysqli_stmt_bind_param($stmt,"ssi",$fullName,$email,$contact);
                      mysqli_stmt_execute($stmt);
                      echo "<div class='alert alert-success'>Registered Successfully</div>";
                    }
                    else{
                      die("Something went wrong");
                    }
                  }
                }
              ?>
          <form method="POST">
            <div class="mb-3">
              <label for="exampleInputName" class="form-label">Full Name</label>
              <input type="text" class="form-control" id="exampleInputName" name="name" required>
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Email address</label>
              <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" required>
            </div>
            <div class="mb-3">
              <label for="exampleInputNumber" class="form-label">Phone Number</label>
              <input type="number" class="form-control" id="exampleInputNumber"name="phone_no"  required>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">ADD</button>
          </form>
        </div>
        <br>
        <br>
        <hr>
<?php
         require_once "database.php";
        $query = "SELECT * FROM driver";


echo '<table class="table"> 
      <thead class="thead-light">
      <tr> 
          <th scope "col"> <font face="Arial">ID</font> </th> 
          <th scope "col"> <font face="Arial">Name</font> </th> 
          <th scope "col"> <font face="Arial">Date of Joining</font> </th> 
          <th scope "col"> <font face="Arial">Contact</font> </th> 
          <th scope "col"> <font face="Arial">Email</font> </th> 
      </tr>
      </thead>
      ';

if ($result = mysqli_query($conn,$query)) {
  $rowCount=mysqli_num_rows($result);
  echo "Total Drivers:".$rowCount;
    while ($row = $result->fetch_assoc() AND  $rowCount > 0) {
        $field1name = $row["DriverID"];
        $field2name = $row["DriverName"];
        $field3name = $row["DateOfJoining"];
        $field4name = $row["Contact"];
        $field5name = $row["email"];
        echo '<tr> 
                  <td>'.$field1name.'</td> 
                  <td>'.$field2name.'</td> 
                  <td>'.$field3name.'</td> 
                  <td>'.$field4name.'</td> 
                  <td>'.$field5name.'</td> 
              </tr>
              ';
              $rowCount--;
    }
    echo '</thead>';
    $result->free();
}
 ?>
                <!--
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Driver Id</th>
              <th scope="col">Name</th>
              <th scope="col">Mobile Number</th>
              <th scope="col">Email</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>

            <tr>
              <th scope="row">1</th>
              <td>Mark</td>
              <td>Otto</td>
              <td>@mdo</td>
              <td>
                  <button type="button" class="btn btn-outline-danger"">
                    <i class="bi bi-trash"></i>
                  </button>
              </td>
            </tr>
            <tr>
              <th scope="row">1</th>
              <td>Mark</td>
              <td>Otto</td>
              <td>@mdo</td>
              <td>
                  <button type="button" class="btn btn-outline-danger"">
                    <i class="bi bi-trash"></i>
                  </button>
              </td>
            </tr>
          </tbody>
        </table>-->
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>
