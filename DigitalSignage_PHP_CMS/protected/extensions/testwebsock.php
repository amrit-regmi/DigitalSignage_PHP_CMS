#!/usr/bin/env php
<?php

require('websockets.php');

 class echoServer extends WebSocketServer {
  //protected $maxBufferSize = 1048576; //1MB... overkill for an echo server, but potentially plausible for other applications.

  
  protected function process ($user, $message) {
    $this->send($user,$message);
   
  }
  
  protected function connected ($user) {
    
  }
  
  protected function closed ($user) {
   
    $conn = new mysqli("localhost","root","","Bigyapan");
    if(isset($user->headers['macaddress'])){ //if the websocket connection is closed by raspberry pi
    $macAdd = $user->headers['macaddress'];
    mysqli_query($conn,"UPDATE Screens SET status='0' WHERE MacAdd='".$macAdd."'")or die(mysqli_error($conn)); //updating the status to database
    $data=array('type'=>'togglestatus','MacAdd'=>$macAdd,'status'=>'0');
    foreach ( $this->users as $users) {
         $this->send($users,  json_encode($data)); //sending message to the screens index page that the raspberrypi is shutdown  
    };
    }
  }
}

global $echo;
 $echo = new echoServer("0.0.0.0","9000");

try {
  $echo->run();
}
catch (Exception $e) {
  $echo->stdout($e->getMessage());
}


