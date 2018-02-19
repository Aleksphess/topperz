<?php
//$data = file_get_contents("php://input");
//var_dump($data);
$data = array('hello'=>'World');
$data_json = json_encode($data);
 $ch = curl_init('http://dev2.prof.io/index.php');                           
  curl_setopt($ch, CURLOPT_POST, true);                                                                     
  curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);                                                                  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
     'Content-Type: application/json',                                                                                
     'Content-Length: ' . strlen($data_json))                                                                       
  );                
  $response = curl_exec($ch);
echo $response;

echo 'end';
  