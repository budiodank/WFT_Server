<?php
  require_once "config.php";
  // Begin of CORS things
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET');
  header('Content-Type: application/json');


  if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('HTTP/1.1 204 No Content');
    die;
  }
  // End of CORS things
   
  $post = json_decode(file_get_contents('php://input'),true);

  $config = new Config();
  date_default_timezone_set('Asia/Jakarta');

  $action = "all";

  $res = array('error' => false);

  if (isset($_GET['action'])) {
    $action = $_GET['action'];
  }

  if ($action == "sum") {
    $time_c = date("H:i:s");
    $result = $config->toolDtl($action, $time_c);
    $tools_detail = array();

    while ($row = $result->fetch_assoc()){
      array_push($tools_detail, $row);
    }
    $res['tools_detail'] = $tools_detail;
  }
  
  if ($action == "last_top") {
    $time_c = date("H:i:s");
    $result = $config->toolDtl($action, $time_c);
    $tools_detail = array();

    while ($row = $result->fetch_assoc()){
      array_push($tools_detail, $row);
    }
    $res['tools_detail'] = $tools_detail;
  }

  if ($action == "hour") {
    $time_c = date("H:i:s");
    $result = $config->toolDtl($action, $time_c);
    $tools_detail_hour = array();

    while ($row = $result->fetch_assoc()){
      array_push($tools_detail_hour, $row);
    }
    $res['tools_detail_hour'] = $tools_detail_hour;
  }

  if ($action == "weeks") {
    $time_c = date("H:i:s");
    $result = $config->toolDtl($action, $time_c);
    $tools_detail_week = array();

    while ($row = $result->fetch_assoc()){
      array_push($tools_detail_week, $row);
    }
    $res['tools_detail_week'] = $tools_detail_week;
  }

  if ($action == "months") {
    $time_c = date("H:i:s");
    $result = $config->toolDtl($action, $time_c);
    $tools_detail_month = array();

    while ($row = $result->fetch_assoc()){
      array_push($tools_detail_month, $row);
    }
    $res['tools_detail_month'] = $tools_detail_month;
  }
  
  //Problem
  if ($action == "hour_problem") {
    $time_c = date("H:i:s");
    $result = $config->toolDtl($action, $time_c);
    $tools_detail_hour_problem = array();

    while ($row = $result->fetch_assoc()){
      array_push($tools_detail_hour_problem, $row);
    }
    $res['tools_detail_hour_problem'] = $tools_detail_hour_problem;
  }

  if ($action == "weeks_problem") {
    $time_c = date("H:i:s");
    $result = $config->toolDtl($action, $time_c);
    $tools_detail_week_problem = array();

    while ($row = $result->fetch_assoc()){
      array_push($tools_detail_week_problem, $row);
    }
    $res['tools_detail_week_problem'] = $tools_detail_week_problem;
  }

  if ($action == "months_problem") {
    $time_c = date("H:i:s");
    $result = $config->toolDtl($action, $time_c);
    $tools_detail_month_problem = array();

    while ($row = $result->fetch_assoc()){
      array_push($tools_detail_month_problem, $row);
    }
    $res['tools_detail_month_problem'] = $tools_detail_month_problem;
  }

  if ($action == "normal") {
    $time_c = date("H:i:s");
    $result = $config->toolDtl($action, $time_c);
    $tools_detail_normal = array();

    while ($row = $result->fetch_assoc()){
      array_push($tools_detail_normal, $row);
    }
    $res['tools_detail_normal'] = $tools_detail_normal;
  }

  if ($action == "problem") {
    $time_c = date("H:i:s");
    $result = $config->toolDtl($action, $time_c);
    $tools_detail_problem = array();

    while ($row = $result->fetch_assoc()){
      array_push($tools_detail_problem, $row);
    }
    $res['tools_detail_problem'] = $tools_detail_problem;
  }

  if ($action == "all") {
    $time_c = date("H:i:s");
    $result = $config->toolDtl($action, $time_c);
    $tools_detail = array();

    while ($row = $result->fetch_assoc()){
      array_push($tools_detail, $row);
    }
    $res['tools_detail'] = $tools_detail;
  }


  header("Content-type: application/json");
  echo json_encode($res);
  die();
 ?>