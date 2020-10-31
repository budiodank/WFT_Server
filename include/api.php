<?php 
  /**
   * 
   */
  class Api
  {
    
    public function getData()
    {
      $AccessTokenUri = "https://platform.antares.id:8443/~/antares-cse/antares-id/spa";
 
      $accessKey = "bb327cc637b950e3:9c5bddd209bad89a"; 
      $options = array(
        'http' => array(
            'header'  => "X-M2M-Origin:". $accessKey."\r\n" .
                        "Content-Type: application/json;ty=4\r\n".
                        "Accept: application/json\r\n",
           
            'method'  => 'GET',
        ),
      );

      $context  = stream_context_create($options);

      //get the Access Token
      $access_token = file_get_contents($AccessTokenUri, false, $context);

      if (!$access_token) {
        throw new Exception("Problem with $AccessTokenUri, $php_errormsg");
      }
        else{
          $result = json_decode($access_token,true);

    //$aa = json_decode($access_token,true);
    //print_r($access_token);
    //echo $access_token."<br />";
          //echo $x['"m2m:cin']['con'];
          //$xx = $x["m2m:cin"]["con"];
          //$xxx = json_decode($xx, true);
          //var_dump($x["m2m:cin"]["con"]);
          //var_dump($xx);
          //print_r($access_token);
          //echo $access_token;
    //echo $access_token['m2m:cin']['con'];
    //var_dump($access_token);

        return $result;
      }
    }
  }

	
?>