<?php
  require_once "config.php";
  // Begin of CORS things
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
  header('Content-Type: application/json');


  if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('HTTP/1.1 204 No Content');
    die;
  }
  // End of CORS things
   
  $post = json_decode(file_get_contents('php://input'),true);

  //$requestBody = file_get_contents('php://input');

  //print_r($requestBody);

  $config = new Config();
  date_default_timezone_set('Asia/Jakarta');

  $action = "read";

  $res = array('error' => false);

  if (isset($_GET['action'])) {
    $action = $_GET['action'];
  }
  
  if ($action == "read") {
    $fromDate = $post['fromDate'];
    $toDate = $post['toDate'];
    $dataSensor = $post['dataSensor'];
    
    if($dataSensor == "all")
    {
        $dataSensor = "";
    }

    if ($fromDate != '' && $toDate != '')  {
      $result = $config->selReport($fromDate,$toDate,$dataSensor);
      if ($result) {
        $res['message'] = "Data";
        $res['fromDate'] = $fromDate;
        $res['toDate'] = $toDate;
        $res['dataSensor'] = $dataSensor;
        $report = array();

        while ($row = $result->fetch_assoc()){
          array_push($report, $row);
        }
        $res['report'] = $report;
      } else {
        $res['error'] = true;
        $res['message'] = "Data not found";
      }
    } else {
        $res['error'] = true;
        $res['message'] = "Please input fill";
        $res['fromDate'] = $fromDate;
        $res['toDate'] = $toDate;
        $res['dataSensor'] = $dataSensor;
    }
    
  }
  
  
  header("Content-type: application/json");
  echo json_encode($res);
  die();


?>