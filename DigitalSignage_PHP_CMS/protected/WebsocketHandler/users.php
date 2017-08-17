<?php

class WebSocketUser {
   
  public $type;
  public $socket;
  public $id;
  public $headers = array();
  public $handshake = false;
  public $uniqe = array();

  public $handlingPartialPacket = false;
  public $partialBuffer = "";

  public $sendingContinuous = false;
  public $partialMessage = "";
  
  public $hasSentClose = false;

  function __construct($id, $socket , $type = null) {
    $this->id = $id;
    $this->socket = $socket;
    $this->type = $type;
  }
}