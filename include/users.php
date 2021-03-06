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
    $result = $config->selTechnician();
    $users = array();

    while ($row = $result->fetch_assoc()){
      array_push($users, $row);
    }
    $res['users'] = $users;
  }

  if ($action == "view") {
    $id = $_GET['id'];
    $result = $config->getTechnician($id);
    $users = array();

    while ($row = $result->fetch_assoc()){
      array_push($users, $row);
    }
    $res['users'] = $users;
  }

  if ($action == "add") {
    $userId = $config->userId(9);
    $name = $post['name'];
    $address = $post['address'];
    $telp_no = $post['telp_no'];
    $username = $post['username'];
    $password = md5($post['password_confirm']);
    $level = "teknisi";
    $date = date("Y-m-d H:i:s");//echo "date :".$date."<br />";

    if ($userId != '' && $name != '' && $address != '' && $telp_no != '' && $username != '' && $password != '')  {
      $add = $config->addTechnician($userId, $name, $address, $telp_no, $username, $password, $level, $date);
      if ($add) {
        $res['message'] = "User Added successfully";
      } else {
        $res['error'] = true;
        $res['message'] = "Insert user fail";
      }
    } else {
        $res['error'] = true;
        $res['message'] = "Please input fill";
    }
  }
  
  if ($action == "edit") {
    $userId = $post['user_id'];
    $name = $post['name'];
    $address = $post['address'];
    $telp_no = $post['telp_no'];
    $date = date("Y-m-d H:i:s");//echo "date :".$date."<br />";

    if ($userId != '' && $name != '' && $address != '' && $telp_no != '')  {
      $edit = $config->upTechnician($userId, $name, $address, $telp_no, $date);
      if ($edit) {
        $res['message'] = "User Editted successfully";
      } else {
        $res['error'] = true;
        $res['message'] = "Edit user fail";
      }
    } else {
        $res['error'] = true;
        $res['message'] = "Please input fill";
    }
  }
  
  if ($action == "delete") {
    $userId = $_get['user_id'];

    if ($userId != '')  {
      $delete = $config->delTechnician($userId);
      if ($delete) {
        $res['message'] = "User Deleted successfully";
      } else {
        $res['error'] = true;
        $res['message'] = "Delete user fail";
      }
    } else {
        $res['error'] = true;
        $res['message'] = "Please input fill";
    }
  }
  
  if ($action == "login") {
    $username = $post['username'];
    $password = md5($post['password']);

    if ($username != '' && $password != '') {
      $result = $config->login($username, $password);
      if ($result) {
        $res['message'] = "Login successfully";
        $users = array();

        while ($row = $result->fetch_assoc()){
          array_push($users, $row);
        }
        $res['users'] = $users;
      } else {
        $res['error'] = true;
        $res['message'] = "Login failed";
      }
    } else {
        $res['error'] = true;
        $res['message'] = "Please input username or password";
    }
  }



  header("Content-type: application/json");
  echo json_encode($res);
  die();
 ?>