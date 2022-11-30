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
  <?php
        session_start();
        //echo $_SESSION['user_name']
        $email =$_SESSION['user_email'];
        $uname=$_SESSION['user_name'];
        $uid=$_SESSION['user_id'];
        ?>
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
          <a class="nav-link d-flex" style="color: white; padding: 20px;">
            <span class="border border-dark rounded-pill fs-4" style="padding-left:5px ; padding-right: 5px;">
              <i class="bi bi-coin text-warning"></i>
              <?php
              require_once "database.php";
              $query="SELECT rewardpoint from users where id='$uid'";
              $result=mysqli_query($conn,$query);
              $pnt=mysqli_fetch_array($result);
              $pt=$pnt["rewardpoint"];
              ?>
              <span class="badge"><?= $pt ?></span>
            </span>
          </a>
          <a class="nav-link d-flex" style="color: white; padding-right: 20px;"><i class="bi bi-person-fill"></i></a>
        </div>
      </div>
    </nav>
    <div class="sidebar" style="background-color: #0e1a35; color: white;">
      <div style="text-align:center;">
        <img src="assests/download-removebg-preview.png" class="rounded" alt="user_image">
        
        <p><?= $uname ?></p>
      </div>
      <hr><a href="userdashboard.php"><i class="bi bi-house-door mx-2"></i>Dashboard</a>
      <a href="lodgecomplain.php"><i class="bi bi-files mx-2"></i>Lodge Complain</a>
      <!--<a href="complainhistory.php"><i class="bi bi-files mx-2"></i>Complain History</a>-->
      <a href="searchcomplain.php"><i class="bi bi-search mx-2"></i>Search</a>
      <a href="viewlodgedcomplain.php"><i class="bi bi-search mx-2"></i>View complains</a>
    </div>
    <div class="content" style="background-color: #edeff0;">
      <span class="d-block" style="background-color: #a1a5ad;margin-left: 80px; padding: 10px; padding-left: 30px;"><p class="fs-4">View Lodged Complain</p></span>
      <div class="container p-4" style="background-color: white; margin-left: 150px; margin-top: 50px;">
        <p class="fs-5" style="padding-bottom: 20px;"><b>View Lodged Complain</b></p>
        <hr>
        <div class="container text-start">
          <?php
        require_once "database.php";
         $query = "SELECT * FROM complain where userID='$uid'";
         $result = mysqli_query($conn,$query);
         $rowcount= mysqli_num_rows($result);
         echo "Total Complains : ".$rowcount;
         if($rowcount>0)
         {
         while ($row = $result->fetch_assoc() AND  $rowcount > 0) {
          $comno=$row["compID"];
         $Area = $row["Area"];
        $Locality = $row["Locality"];
        $Landmark = $row["Landmark"];
        $qry="SELECT status from source where comp_no='$comno'";
        $res=mysqli_query($conn,$qry);
        $rr=mysqli_fetch_array($res,MYSQLI_ASSOC);
        $status=$rr["status"];
        if(empty($status))
        {
            $sts="not picked";
        }
        else{
          $sts="picked";}
          //
          echo '
          <div class="row fw-bolder" style="color: #fcba03;">
            <div class="col-3 border p-3">Complain Number</div>
            <div class="col-9 border p-3">'.$comno.'</div>
          </div>

          <div class="row row-cols-4">
            <div class="col border p-3 fw-semibold">Area</div>
            <div class="col border p-3">'.$Area.'</div>
            <div class="col border p-3 fw-semibold">Locality</div>
            <div class="col border p-3">'.$Locality.'</div>
          </div>

          <div class="row row-cols-4">
            <div class="col border p-3 fw-semibold">Landmark</div>
            <div class="col border p-3">'.$Landmark.'</div>
            <div class="col border p-3 fw-semibold">Complain Final Status</div>
            <div class="col border p-3">'.$sts.'</div>
          </div>

          ';


          //
                $rowcount--;
      }
        
        }else{
          echo "<div class='alert alert-danger'>No complains lodged</div>";
        }
          ?>

        </div>

      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>
