<?php
require_once "config.php";
/**
 * 
 */
class Api_SMS
{
  public function smsData($tool, $vibration_normal, $vibration_problem, $water_flow_normal, $water_flow_problem,$water_level,$relay)
  {
    $config = new Config();
  

    $no_telp = '';
    //$accessKey = "2f2b5c0e49d365b0:f68b99c78b62a9b3"; 
    $selTechnician = $config->selTechnician();
    if ($selTechnician) {      
      foreach ($selTechnician as $data) {
        //echo $data['telp_no'];
        $no_telp = $data['telp_no'];

        //sendSms($no_telp, $vibration_problem, $water_flow_problem, $water_level, $relay);
        //echo $no_telp;
      }
    } else {
      echo "Gagal get data";
    }
  }

  public function sendSms($no_telp, $vibration_problem, $water_flow_problem, $water_level, $relay)
  {
    $AccessTokenUri = "https://api.thebigbox.id/sms-notification/1.0.0/messages";

   // $messages = 'Getaran '.$vibration.' Arus Air '.$water_flow.' Ketinggian Air '.$water_level.' Relay '.$relay;
   
   $messages = 'Test123';

    //$data  =  json_encode(array("msisdn" => "087784677284", "content" => "Test12345"));

    $data = array ('msisdn' => $no_telp, 'content' => $messages);
    $data2 = http_build_query($data);

    $options = array(
      'http' => array(
          'header'  =>  "Content-Type: application/x-www-form-urlencoded\r\n".
                        "Accept: application/x-www-form-urlencoded\r\n".
                        "x-api-key: VtSUan73HRZgZDIStSfb4PfCb1cYlzMP\r\n",
         
          'method'  => 'POST',

          'content'  => $data2,
      ),
    );

    $context  = stream_context_create($options);

    //get the Access Token
    $access_token = file_get_contents($AccessTokenUri, false, $context);

    if (!$access_token) {
      throw new Exception("Problem with $AccessTokenUri, $php_errormsg");
    } else{ 
      $result = json_decode($access_token,true);
    }
  }
}

 ?>