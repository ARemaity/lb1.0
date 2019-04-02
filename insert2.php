<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//Creating Array for JSON response
$response = array();
date_default_timezone_set("Asia/Beirut");
$date = date('Y-m-d');
// Check if we got the field from the user
if (isset($_GET['fk_client']) && isset($_GET['val'])) {

    $fk_client = $_GET['fk_client'];
    $val = $_GET['val'];
 // Include data base connect class
 $filepath = realpath (dirname(__FILE__));
 require_once($filepath."/db_connect.php");


 // Connecting to database 
 $db = new DB_CONNECT();

 //check last id by the query and get it by tranforming it to object 
    $checkLastid = mysql_query("SELECT id FROM hour_value ORDER BY id DESC LIMIT 1 ");
    $value = mysql_fetch_object($checkLastid);
    $id=$value->id;
    $debug = array(

        'id' => $fk_client,
        'val' =>$val,
        'lastStatus' =>0,
        'inserthour'=>0,
        'insertday' =>0,
        'delete' =>0,
        'reset' =>0,

    );

    if($checkLastid){
        $debug['lastStatus']=1;
    //if the id of last auto incremented value 24 or more sum up and insert it to the vlaue of day and reset the id and delete all value
        $result = mysql_query("INSERT INTO hour_value(fk_client,val) VALUES('$fk_client','$val')");
        if($result){

            $debug['inserthour']=1;
        
        if ($id >= 24) {
        $sumHourQ = mysql_query(" SELECT SUM(val) as sum FROM hour_value;");
        $sumHour = mysql_fetch_object($sumHourQ);
        $sum=$sumHour->sum;
        if ($sumHourQ) {
            /*$checkLastidDay=mysql_query("SELECT id FROM day_value ORDER BY id DESC LIMIT 1 ");
            //if( $checkLastidDay>=30){
            // $sumDay = mysql_query(" SELECT SUM(val) FROM day_value;");
            // if($sum){
            //  $insert = mysql_query(" INSERT INTO month_value(fk_client,val,time)  VALUES ($fk_client,$sumDay,day_value");*/
           $insert = mysql_query(" INSERT INTO day_value(fk_client,value,dates)  VALUES ('$fk_client','$sumHour','$date'");
           if ($insert) {
               $debug['insertday']=1;
               $delete = mysql_query("DELETE FROM hour_value");

               if ($delete) {
                $debug['delete']=1;
                  $reset = mysql_query("ALTER TABLE `hour_value` AUTO_INCREMENT=1");
                  if($reset){

                    $debug['reset']=1;
                  }
                }
            }
        }

    /* 
        $reset=mysql_query("ALTER TABLE `hour_value` AUTO_INCREMENT=1");
        $delete=mysql_query("DELETE FROM hour_value");
       
        if( $checkLastidDay>=24){
            $sum = mysql_query(" SELECT SUM(val) FROM hour_value;");
            $reset=mysql_query("ALTER TABLE `hour_value` AUTO_INCREMENT=1");
            $delete=mysql_query("DELETE FROM hour_value");


        }
      
    }
    */

        } 
  
    }  
}


/*
        $result = mysql_query("INSERT INTO hour_value(fk_client,val) VALUES('$fk_client','$val')");

        if ($checkLastid) {

           // $response["success"] = 1;
           // $response["message"] = $checkLastid;
            echo json_encode($a);
        } else {*/
            // Failed to insert data in database
            /*$response["success"] = 0;
            $response["message"] = "Something has been wrong and the fk_client=" + $fk_client + "  and the value is " + $val;

            // Show JSON response
            echo json_encode($response);*/
        
            echo json_encode($debug);
} else {
    // If required parameter is missing
    $response["success"] = 0;
    $response["message"] = "Parameter(s) are missing. Please check the request";

    // Show JSON response
    echo json_encode($response);
}
 ?>