<?php
 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
//Creating Array for JSON response
$response = array();
 
// Check if we got the field from the user
if ( isset($_GET['fk_client'])&&isset($_GET['val'])) {
 
    $fk_client=$_GET['fk_client'];
    $val=$_GET['val'];
    // Include data base connect class
    $filepath = realpath (dirname(__FILE__));
	require_once($filepath."/db_connect.php");
 
 
    // Connecting to database 
    $db = new DB_CONNECT();
    
    $result = mysql_query("INSERT INTO hour_value(fk_client,val) VALUES('$fk_client','$val')");
 
    // Check for succesfull execution of query
    if ($result) {
        // successfully inserted 
        $response["success"] = 1;
        $response["message"] = "Weather successfully created.";
 
        // Show JSON response
        echo json_encode($response);
    } else {
        // Failed to insert data in database
        $response["success"] = 0;
        $response["message"] = "Something has been wrong and the fk_client="+$fk_client+"  and the value is "+$val;
 
        // Show JSON response
        echo json_encode($response);
    }
} else {
    // If required parameter is missing
    $response["success"] = 0;
    $response["message"] = "Parameter(s) are missing. Please check the request";
 
    // Show JSON response
    echo json_encode($response);
}
?>