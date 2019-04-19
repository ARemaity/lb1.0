<?php
/////////////////////////////////////////
$servername = "localhost";
$username = "id8992783_root";
$password = "isd4us";
$dbname = "id8992783_isd";
$idHour = 0;
$idDay = 0;
$idMonth = 0;
$idPaymemt = 0;
$getCumumlative=0;
header("Content-type: application/json; charset=utf-8");
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
mysqli_set_charset($conn, "utf8");
$response = array();
date_default_timezone_set("Asia/Beirut");
$dates = date('Y-m-d');
//////////////////////////


//Creating Array for JSON response

//$dts=strlen($date);
//$dts='1999-12-02';   //..there is problem with dates so we use 1999 as example
// Check if we got the field from the user
if (isset($_GET['fk_client']) && isset($_GET['val'])) {

    $fk_client = $_GET['fk_client'];
    $val = $_GET['val'];
    $forcum=$val;
    // Include data base connect class

    // Connecting to database 
    $getdata = mysqli_query($conn, "SELECT value FROM  Cumulative ");
    if (mysqli_num_rows($getdata)==0) {
        $insert= mysqli_query($conn,"INSERT INTO Cumulative(fk_client,value)  VALUES ('" . $fk_client . "','" . $val . "')") or die(mysqli_error($conn));

    }
else{
       
    $cum = mysqli_fetch_object($getdata);
    $getCumumlative  = (int)$cum->value;
    $forcum=$val+$getCumumlative;
    $insert= mysqli_query($conn,"UPDATE  Cumulative Set `value`= '". $forcum . "' Where fk_id='".$fk_client."'");}

    //check last id by the query and get it by tranforming it to object 
    $checkLastid = mysqli_query($conn, "SELECT id FROM hour_value ORDER BY id DESC LIMIT 1 ");

    if (mysqli_num_rows($checkLastid)==0) {

        $idHour = 1;
    } else {
        $value = mysqli_fetch_object($checkLastid);

        $idHour = (int)$value->id;
    }
    $debug = array(

        'val' => $val,
        'lasthourQ' => 0,
        '@last id obtain' => $idHour,
        '@last id inserted' => $idHour + 1,
        'lastDayQ' => 0,
        '%last id obtain' => $idDay,
        '%last id inserted' => $idDay + 1,
        'inserthour' => 0,
        'insertDay' => 0,
        'insertMonth' => 0,
        'API.hour' => 0,
        'API.day' => 0,
        'API.month' => 0,


    );  

    if ($checkLastid) {
        $debug['lasthourQ'] = 1;
        if ($idHour < 10) {
            //if the id of last auto incremented value 24 or more sum up and insert it to the vlaue of day and reset the id and delete all value
            $result = mysqli_query($conn, "INSERT INTO hour_value(fk_client,val) VALUES('" . $fk_client . "','" . $val . "')");
            if ($result) {
                $debug['API.hour'] = 1;
            }
        } else if ($idHour >= 10) {

            $sumHourQ = mysqli_query($conn, " SELECT SUM(val) as sums FROM hour_value;") or die(mysqli_error($conn));
            $sumHour = mysqli_fetch_object($sumHourQ);
            $fsumHour = $sumHour->sums;
            if ($sumHourQ) {

                $Lastday = mysqli_query($conn, "SELECT id FROM day_value ORDER BY id DESC LIMIT 1 ");
                if (mysqli_num_rows($Lastday)==0) {

                    $idDay = 1;
                } else {
                    $dayvalue = mysqli_fetch_object($Lastday);
                    $idDay = (int)$dayvalue->id;
                }
                if ($Lastday) {
                    $debug['lastDayQ'] = 1;
                    if ($idDay < 4) {
                        $insert = mysqli_query($conn, " INSERT INTO day_value(fk_client,value,dates)  VALUES ('" . $fk_client . "','" . $fsumHour . "','" . $dates . "')") or die(mysqli_error($conn));
                        if ($insert) {
                            $debug['insertDay'] = 1;
                            $delete = mysqli_query($conn, "DELETE FROM hour_value");
                            if ($delete) {
                                $reset = mysqli_query($conn, "ALTER TABLE `hour_value` AUTO_INCREMENT=1");
                                if ($reset) {
                                    $debug['API.day'] = 1;
                                }
                            }
                        }
                    } else if ($idDay >= 4) {
                        $sumDayQ = mysqli_query($conn, " SELECT SUM(value) as sums FROM day_value;") or die(mysqli_error($conn));
                        $sumDay = mysqli_fetch_object($sumDayQ);
                        $fsumDay = $sumDay->sums;
                        if ($sumDayQ) {
                            $debug['sumDay'] = 1;
                            $insertDay = mysqli_query($conn, " INSERT INTO month_value(fk_client,value,dates)  VALUES ('" . $fk_client . "','" . $fsumDay . "','" . $dates . "')") or die(mysqli_error($conn));
                            if ($insertDay) {
                                $debug['insertMonth'] = 1;
                                $delete = mysqli_query($conn, "DELETE FROM day_value");
                                if ($delete) {

                                    $reset = mysqli_query($conn, "ALTER TABLE `day_value` AUTO_INCREMENT=1");
                                    if ($reset) {

                                        $delete = mysqli_query($conn, "DELETE * FROM  Cumulative WHERE fk_id ='".$fk_client."'");
                                        $debug['API.month'] = 1;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    echo json_encode($debug); //  show json debug 

} else {
    // If required parameter is missing
    $response["success"] = 0;
    $response["message"] = "Parameter(s) are missing. Please check the request";

    // Show JSON response
    echo json_encode($response);
}
?>