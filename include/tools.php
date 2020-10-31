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
    $result = $config->selTools();
    $tools = array();

    while ($row = $result->fetch_assoc()){
      array_push($tools, $row);
    }
    $res['tools'] = $tools;
  }

  if ($action == "add") {
    $userId = $config->userId(6);
    $name = $post['name'];
    $lat = $post['lat'];
    $lng = $post['lng'];
    $description = $post['description'];
    $created_by = 'admin';
    $date = date("Y-m-d H:i:s");//echo "date :".$date."<br />";

    if ($userId != '' && $name != '' && $lat != '' && $lng != '') {
      $add = $config->addTools($userId, $name, $lat, $lng, $description, $created_by, $date);
      if ($add) {
        $res['message'] = "Tool Added successfully";
      } else {
        $res['error'] = true;
        $res['message'] = "Insert Tool fail";
      }
    }
  }


  header("Content-type: application/json");
  echo json_encode($res);
  die();
 ?>