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
        
      <?php
          if(isset($_POST["submit"])){
            $source=$_POST["source"];
            $vehicle=$_POST["vehicle"];
            $driver=$_POST["driver"];

            $errors= array();
            
            if($source<0 OR $vehicle<0 OR $driver<0){
              array_push($errors,"All fields are required");
            }
            if(count($errors)>0){
              foreach($errors as $errors){
                echo "<div class='alert alert-danger'>$errors</div>";
              }
            }
            else{
            require_once "database.php";
            $sql="UPDATE source set DriverID='$driver',VehicleNo='$vehicle' where SourceID='$source'";
            $result=mysqli_query($conn,$sql);
            if($result)
            {
              echo "<script>alert('Driver Assigned')</script>";
            }
            else{echo "Driver Not Assigned";}
            
            }
          }
    ?>
      <form method="POST">
          <label style="padding-bottom: 10px;">Source</label>
          <select class="form-select" aria-label="Default select example" name="source">
          <option value="-1">Select Source</option>
          <?php
          require_once "database.php";
                    $query = "SELECT * FROM source where DriverID is null";
                    $results=mysqli_query($conn, $query);
                    //loop
                    foreach ($results as $src){
                ?>
                        <option value="<?php echo $src["SourceID"];?>"><?php echo $src["SourceID"]; echo "  "; echo $src["Area"];echo "  ,"; echo $src["Locality"];echo "  ,"; echo $src["Landmark"];?></option>
                <?php
                    }
                ?>
          </select>
          <br>
          <label style="padding-bottom: 10px;">Vehicle</label>
          <select class="form-select" aria-label="Default select example" name="vehicle">
            <option selected value="-1">Select Vehicle</option>
            <option value="1">Vehicle 1</option>
            <option value="2">Vehicle 2</option>
            <option value="3">Vehicle 3</option>
          </select>
          <br>
          <label style="padding-bottom: 10px;">Driver</label>
          <select class="form-select" aria-label="Default select example" name="driver">
          <option value="-1">Select Driver</option>
          <?php
          //require_once "database.php";
                    $query = "SELECT * FROM driver";
                    $results=mysqli_query($conn, $query);
                    //loop
                    foreach ($results as $src){
                ?>
                        <option value="<?php echo $src["DriverID"];?>"><?php echo $src["DriverID"]; echo "  "; echo $src["DriverName"];?></option>
                <?php
                    }
                ?>
          </select>
          <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>
