<?php


require_once "config.php";
require_once "sms_api.php";

$config = new Config();
$api_sms = new Api_SMS();
date_default_timezone_set('Asia/Jakarta');

function sms_data_api($tool, $vibration_normal, $vibration_problem, $water_flow_normal, $water_flow_problem,$water_level,$relay)
{
   // $api_sms->smsData($tool, $vibration_normal, $vibration_problem, $water_flow_normal, $water_flow_problem,$water_level,$relay);
}

// Begin of CORS things
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('HTTP/1.1 204 No Content');
    die;
}

// Keep this API Key value to be compatible with the ESP32 code provided in the project page. 
// If you change this value, the ESP32 sketch needs to match
$api_key_value = "tPmAT5Ab3j7F9";

$api_key = "";



$action = "all";

$res = array('error' => false);

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}
   
$post = json_decode(file_get_contents('php://input'),true);

if ($action == "add") {
    $api_key = input_trim($post["api_key"]);
    if($api_key == $api_key_value) {
        $tool = input_trim($post["tool"]);
        $vibration = input_trim($post["vibration"]);
        $waterflow = input_trim($post["waterflow"]);
        $waterlevel = input_trim($post["waterlevel"]);
        $relay = input_trim($post["relay"]);
        $date = date("Y-m-d H:i:s");
        $status = "";
        if($vibration <= 0 || $waterflow <= 0 || $waterlevel <= 0 || $relay <= 0)
        {
            $status = "problem";
        } else {
            $status = "normal";
        }
        
    
        if ($action == "add") {
            $result = $config->addToolDtl($tool, $vibration, $waterflow, $waterlevel, $relay, $date, $status);
            /*$tools_detail = array();
    
            while ($row = $result->fetch_assoc()){
                array_push($tools_detail, $row);
            }*/
            
            if($status == "problem")
            {
                $api_sms->smsData($tool, $vibration, $waterflow, $waterlevel, $relay);
            }
            $res['tools_detail'] = array("message" => "Berhasil Masuk Database");
        } else {
            $res['tools_detail'] = array("message" => "Gagal");
        }
    } else {
        $res['tools_detail'] = array("message" => "Wrong API Key provided.");
        //echo "Wrong API Key provided.";
    }
}

if ($action == "addVibration") {
    $api_key = input_trim($post["api_key"]);
    if($api_key == $api_key_value) {
        $tool = input_trim($post["tool"]);
        $vibration = input_trim($post["vibration"]);
        $date = date("Y-m-d H:i:s");
        $status = "";
        if($vibration <= 0)
        {
            $status = "problem";
        } else {
            $status = "normal";
        }
        
    
        if ($action == "addVibration") {
            $result = $config->addVibration($tool, $vibration, $date, $status);
            /*$tools_detail = array();
    
            while ($row = $result->fetch_assoc()){
                array_push($tools_detail, $row);
            }*/
            
            /*if($status == "problem")
            {
                $api_sms->smsData($tool, $vibration, $waterflow, $waterlevel, $relay);
            }*/
            $res['tools_detail'] = array("message" => "Berhasil Masuk Database");
        } else {
            $res['tools_detail'] = array("message" => "Gagal");
        }
    } else {
        $res['tools_detail'] = array("message" => "Wrong API Key provided.");
        //echo "Wrong API Key provided.";
    }
}

if ($action == "addWaterFlow") {
    $api_key = input_trim($post["api_key"]);
    if($api_key == $api_key_value) {
        $tool = input_trim($post["tool"]);
        $water_flow = input_trim($post["water_flow"]);
        $date = date("Y-m-d H:i:s");
        $status = "";
        if($water_flow <= 0)
        {
            $status = "problem";
        } else {
            $status = "normal";
        }
        
    
        if ($action == "addWaterFlow") {
            $result = $config->addWaterFlow($tool, $water_flow, $date, $status);
            /*$tools_detail = array();
    
            while ($row = $result->fetch_assoc()){
                array_push($tools_detail, $row);
            }*/
            
            /*if($status == "problem")
            {
                $api_sms->smsData($tool, $vibration, $waterflow, $waterlevel, $relay);
            }*/
            $res['tools_detail'] = array("message" => "Berhasil Masuk Database");
        } else {
            $res['tools_detail'] = array("message" => "Gagal");
        }
    } else {
        $res['tools_detail'] = array("message" => "Wrong API Key provided.");
        //echo "Wrong API Key provided.";
    }
}

if ($action == "addWaterLevel") {
    $api_key = input_trim($post["api_key"]);
    if($api_key == $api_key_value) {
        $tool = input_trim($post["tool"]);
        $water_level = input_trim($post["water_level"]);
        $date = date("Y-m-d H:i:s");
        $status = "";
        if($water_level <= 0)
        {
            $status = "problem";
        } else {
            $status = "normal";
        }
        
    
        if ($action == "addWaterLevel") {
            $add = $config->addWaterLevel($tool, $water_level, $date, $status);
           
            
            if($status == "problem")
            {
                $result = $config->toolDtl("sum", "2020");
                
                while ($row = $result->fetch_assoc()){
                  $vibration_normal = $row['vibration_normal'];
                  $vibration_problem = $row['vibration_problem'];
                  $water_flow_normal = $row['water_flow_normal'];
                  $water_flow_problem = $row['water_flow_problem'];
                  $water_level = $row['water_level'];
                  $relay = $row['relay1'];
                }
                
                if($vibration_normal == "0" || $water_flow_normal == "0")
                {
                   // $api_sms->smsData($tool, $vibration_normal, $vibration_problem, $water_flow_normal, $water_flow_problem,$water_level,$relay);
                   sms_data_api($tool, $vibration_normal, $vibration_problem, $water_flow_normal, $water_flow_problem,$water_level,$relay);
                }   
                
            }
            $res['tools_detail'] = array("message" => "Berhasil Masuk Database");
        } else {
            $res['tools_detail'] = array("message" => "Gagal");
        }
    } else {
        $res['tools_detail'] = array("message" => "Wrong API Key provided.");
        //echo "Wrong API Key provided.";
    }
}

if ($action == "addRelay") {
    $api_key = input_trim($post["api_key"]);
    if($api_key == $api_key_value) {
        $tool = input_trim($post["tool"]);
        $relay = input_trim($post["relay"]);
        $date = date("Y-m-d H:i:s");
        $status = "";
        if($relay <= 0)
        {
            $status = "problem";
        } else {
            $status = "normal";
        }
        
    
        if ($action == "addRelay") {
            $result = $config->addRelay($tool, $relay, $date, $status);
            /*$tools_detail = array();
    
            while ($row = $result->fetch_assoc()){
                array_push($tools_detail, $row);
            }*/
            
            /*if($status == "problem")
            {
                $api_sms->smsData($tool, $vibration, $waterflow, $waterlevel, $relay);
            }*/
            $res['tools_detail'] = array("message" => "Berhasil Masuk Database");
        } else {
            $res['tools_detail'] = array("message" => "Gagal");
        }
    } else {
        $res['tools_detail'] = array("message" => "Wrong API Key provided.");
        //echo "Wrong API Key provided.";
    }
}

if ($action == "Problem")
{
    $res['tools_detail'] = array('message' => 'Ada Problem');
}

function input_trim($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

header("Content-type: application/json");
echo json_encode($res);
die();
