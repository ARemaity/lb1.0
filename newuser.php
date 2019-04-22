


<?php 
$servername = "localhost";
$username = "root";
$password ="";
$dbname="id8992783_isd";
$status=0;

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}






//if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
 

  
 $fname=  $_POST["fname"];

  $lname= $_POST["lname"]; 
 
 $phone= $_POST["phone"];
  $city= $_POST["city"];
 //$id=  $_POST["id"];
 //TODO:get uid and send it throgh ajax 
 //TODO:get PID From session and insert in to Client tbl
 $street=  $_POST["street"];
 $email=  $_POST["email"]; 
 // $password= $_POST["password"];
 
 


 $role=0;
 $insert = mysqli_query($conn, " INSERT INTO person (role,fname,lname,city,street,phone,email)  VALUES ('" . $role . "','" . $fname . "','" . $lname ."','" . $city ."','" . $street ."','" . $phone . "','" . $email ."')");
 $insertClient = mysqli_query($conn, " INSERT INTO person (role,fname,lname,city,street,phone,email)  VALUES ('" . $role . "','" . $fname . "','" . $lname ."','" . $city ."','" . $street ."','" . $phone . "','" . $email ."')");
if($insert){

   echo "USER successfull inserted";

}else{
    echo "there is problem ,repeat the process if return contact support";
}
 
 
 ?>
 
 





