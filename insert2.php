<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//Creating Array for JSON response
$response = array();
date_default_timezone_set("Asia/Beirut");
$dates = date('Y-m-d');
//$dts=strlen($date);
//$dts='1999-12-02';   //..there is problem with dates so we use 1999 as example
// Check if we got the field from the user
if (isset($_GET['fk_client']) && isset($_GET['val'])) {

    $fk_client = $_GET['fk_client'];
    $val = $_GET['val'];
    // Include data base connect class
    $filepath = realpath(dirname(__FILE__));
    require_once($filepath . "/db_connect.php");


    // Connecting to database 
    $db = new DB_CONNECT();

    //check last id by the query and get it by tranforming it to object 
    $checkLastid = mysql_query("SELECT id FROM hour_value ORDER BY id DESC LIMIT 1 ");
    
    if(is_null($checkLastid)){

     $ia=1;
        
    }
    else{
    $value = mysql_fetch_object($checkLastid);
   
    $ia = (int)$value->id;
    
    }
    $debug = array(

        'val' => $val,
        'lastStatus' => 0,
        'last id obtain'=> $ia,
        'last id inserted'=> $ia+1,
        'inserthour' => 0,
        'API.day'=>0,
        

    );

    if ($checkLastid) {
        $debug['lastStatus'] = 1;
        if($ia<24){
        //if the id of last auto incremented value 24 or more sum up and insert it to the vlaue of day and reset the id and delete all value
            $result = mysql_query("INSERT INTO hour_value(fk_client,val) VALUES('" . $fk_client . "','" . $val . "')");
                if ($result) {
                        $debug['inserthour'] = 1;}
                }else if ( $ia >= 24) {
               
                $sumHourQ = mysql_query(" SELECT SUM(val) as sums FROM hour_value;") or die(mysql_error());
                $sumHour = mysql_fetch_object($sumHourQ);
                $sum = $sumHour->sums;
                if ($sumHourQ) {
                    $insert = mysql_query(" INSERT INTO day_value(fk_client,value,dates)  VALUES ('" . $fk_client . "','" . $sum . "','" . $dates . "')") or die(mysql_error());
                    if ($insert) {
                       
                        $delete = mysql_query("DELETE FROM hour_value");
                        if ($delete) {
                           
                               $reset = mysql_query("ALTER TABLE `hour_value` AUTO_INCREMENT=1");
                            if ($reset) {

                                $debug['API.day'] = 1;
                            }
                        }
                    }
                }
                
            }
        }
   
    echo json_encode($debug); //  show json debug 
   
  }else {
    // If required parameter is missing
    $response["success"] = 0;
    $response["message"] = "Parameter(s) are missing. Please check the request";

    // Show JSON response
    echo json_encode($response);
}
?>