<?php
$hostName = "localhost";
$dbUser="root";
$dbPassword="";
$dbName="waste";
$conn=mysqli_connect($hostName,$dbUser,$dbPassword,$dbName);

if(!$conn){
    die("Something Went Wrong");
}
?>
