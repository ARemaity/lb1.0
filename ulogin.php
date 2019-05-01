<html>
<head>
  <title>lbpower</title>
  <script src="https://code.jquery.com/jquery-3.4.0.min.js"> </script>
  <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
  <link rel="stylesheet" href="css/ulogin.css" />
</head> 

<body>
<?php

if(!isset($_SERVER['HTTP_REFERER']))
{     echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <body>
<script>
window.location.replace("http://localhost/lb1.0/lb1.0/ulogin.html");</script>   
    </body>
    </html>
        ';   }

else if ( isset($_GET['id'])) {

$uid=$_GET['id'];
$_SESSION['id']=$uid;

echo ' <div id="x" class="y-div">
<button onclick="logout()">Logout</button>
</div>
';

}
else{


echo "sorry bro";

}


?>

<script src="https://www.gstatic.com/firebasejs/4.8.1/firebase.js"></script>
    <script src="js/auth.js"></script>
    <script>
    
    
    function logout() {
            firebase.auth().signOut();
            window.location.replace("http://localhost/lb1.0/lb1.0/ulogin.html");
        }
</script>

</body>
</html>
