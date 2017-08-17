<?php
namespace Wshandler;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use mysqli;

class SocketController implements MessageComponentInterface {
    protected $ripiClients;
    public $macMap; //to map the mac_address\screenid to resource id
    public $admin_browser; //to store the users from other browsers
    public $ripi_browser; //to store instance of raspberrypi browsers
    public $mysqli;
    //public $myself;
    

    public function __construct() {
        $this->ripiClients = array();
        $this->ripi_browser = array();
        $this->macMap=array();
         $this->admin_browser=array();
         $this->mysqli=new mysqli("127.0.0.1","root","1991mpjg","bigyapan");
    }
    

    public function onOpen(ConnectionInterface $conn) {
        //if the raspberry pi is connected it will send the header with macaddress and serial set.
         if($conn->WebSocket->request->getHeader('macaddress') && $conn->WebSocket->request->getHeader('serial')){
                $MacAdd = $conn->WebSocket->request->getHeader('macaddress');
                $serialNumber=$conn->WebSocket->request->getHeader('serial');

                //veryfying if the connected client is raspberrypi registered on our netwrok
               if($this->verifyPi($MacAdd, $serialNumber)){
                echo date("F j, Y, g:i a",time()).' Raspberry-pi client '.$MacAdd.' connected with resource id '.$conn->resourceId.PHP_EOL;
                $this->ripiClients[(string)$MacAdd] = $conn; //storing the connection to pi linked with its macaddress
                $this->macMap[$conn->resourceId]= (string)$MacAdd; //storing the macaddress to macmap with resourceid
                $this->setStatus($MacAdd,'2');
                
                $data=array('type'=>'togglestatus','MacAdd'=>(string)$MacAdd,'status'=>'2');
                    /* @var $users type */
                    foreach ( $this->admin_browser as $users) { //broadcasting message to the connected browsers that the raspberrypi is active
                    $users->send(json_encode($data)); //sending the message   
                }
               }//if the verification fails prompt the user to verify the connection
               else{
                   
                   echo date("F j, Y, g:i a",time()).' Unidentified raspberry pi attempting to  connect '.$conn->resourceId.PHP_EOL;
                   $data=array('type'=>'verification','MacAdd'=>(string)$MacAdd,'serial'=>(string)$serialNumber);
                   foreach ( $this->admin_browser as $users) { //broadcasting message to the connected browsers that the raspberrypi is active
                   $users->send(json_encode($data)); //sending the message   
                }
                
                   $conn->close(); //closing the connection
               }
        }//if the user agent is php client and is running from local host
        elseif($conn->remoteAddress== '127.0.0.1' && $conn->WebSocket->request->getHeader('User-Agent')=='127.0.0.1'){
            echo date("F j, Y, g:i a",time()).' Php-client connected at localhost with resource id '.$conn->resourceId.PHP_EOL;
        }
        else{
            $auth=$this->authenticate($conn->WebSocket->request->getCookies()['PHPSESSID']);
            if($auth!=false){
                if(array_key_exists('adminBrowser',$auth) && $auth['adminBrowser']==1){
                    $this->admin_browser[$conn->resourceId]=$conn;
                    echo date("F j, Y, g:i a",time()).' Admin connected with resource id '.$conn->resourceId.PHP_EOL;
                }
                elseif(array_key_exists('ripiBrowser',$auth)){
                    $this->ripi_browser[$auth['ripiBrowser']] = $conn;  //storeing the connection as screenid
                    $this->macMap[$conn->resourceId]= (string)$auth['ripiBrowser']; //mapping to resourceid
                    echo date("F j, Y, g:i a",time()).' Screen '.$auth['ripiBrowser'].' alive with resource id '.$conn->resourceId.PHP_EOL;    
                }
                else{
                    echo date("F j, Y, g:i a",time()).' I smell something fishy or somthing terrible happened, closing connection '.$conn->resourceId.' Please try again'.PHP_EOL;
                    $conn->close();
                }
            }else{
                
                
                $conn->send(PHP_EOL.'####only authenticated users can acess this server####'.PHP_EOL.PHP_EOL);
                echo date("F j, Y, g:i a",time()).' Malacius user detected closing connection at '.$conn->resourceId.PHP_EOL;
                //echo $conn->WebSocket->request->getCookies()['PHPSESSID'];
                $conn->close();
                
            }
                 //
                 
                //if the connected client is other than pi store the connection with resource id because headers cant be set on javascript
                 
        }/*else{
           
            echo 'Unknown user connected with resource id '.$conn->resourceId.' and php sessionID'.$conn->WebSocket->request->getCookies()['PHPSESSID'].PHP_EOL;
            //echo 'under attack here';
            //$conn->close();
          
        }*/
        
        
    }

    public function onMessage(ConnectionInterface $from, $msg) {   //when the message is received
     //if ($msg!=1){echo $msg.PHP_EOL.PHP_EOL;}
     $msg=  json_decode($msg,true);
     if($msg['type']=='cmd'){ //if the message sent is command
         if(isset($this->ripiClients[(string)$msg['MacAdd']])){//if the requested raspberrypi is avaiable
             
             $command = $msg['cmd'];
             $params = null;
             if ($msg['cmd']=='openTunnel'){ //if the command is to initaiate the tunnel get free port and assign 
                 $params= (string)$this->getFreePort();
             }
    
             
             $data = array('type'=>'cmd','cmd'=>$command,'params'=>$params);
             //print_r($data);
             if($this->ripiClients[(string)$msg['MacAdd']]->send(json_encode($data))){ //forwarding the message to specified raspberrypi
                $data = array('type'=>'ack','ack'=>'1','MacAdd'=>$msg['MacAdd'],'info'=>$params); //sending the acknowledgement that comand is sent to the sender
                $from->send(json_encode($data));  
             }
             
         }else{
             $data = array('type'=>'ack','ack'=>'0','MacAdd'=>$msg['MacAdd']); // if the screen is not available sending the acknowledgement that comand sending failed to the sender
             $from->send(json_encode($data));
         }
         
     }
     elseif($msg['type']=='togglestatus'){
         
          $macAdd=$this->macMap[$from->resourceId];
          if($msg['status']!=0){
              $msg['MacAdd']=$macAdd;
              $macAdd=$this->macMap[$from->resourceId];
              $this->setStatus($macAdd,$msg['status']);
          }else{
              $from->close();
          };  
         foreach ( $this->admin_browser as $users) { //boardcast message to the browsers 
                $users->send(json_encode($msg));   
            }
         
     }elseif($msg['type']=='request'){ //if the browser requested some information about raspberry pi
           if(isset($this->ripiClients[(string)$msg['MacAdd']])){ //if the requested screen is avaiable
             $data = array('type'=>'request','cmd'=>$msg['cmd']); //send the request command to specific pi
             //$from->send('Reqest received'); 
             $this->ripiClients[(string)$msg['MacAdd']]->send(json_encode($data));
         }
     }elseif($msg['type']=='response'){ //if the message is response
         $macAdd=$this->macMap[$from->resourceId];
         $msg['MacAdd']= $macAdd;
         foreach ( $this->admin_browser as $users) { //boardcast message to the browsers 
                //if $users
                $users->send(json_encode($msg));   
            }
     }  elseif($msg['type']=='ack') {//if message is ackwnowledge
         $macAdd=$this->macMap[$from->resourceId];
         $msg['MacAdd']= $macAdd;
         foreach ( $this->admin_browser as $users) { //boardcast message to the browsers 
                $users->send(json_encode($msg));
                
            }
     }
     elseif($msg['type']=='push'){
         $from->close();
         if(array_key_exists('remove',$msg['Screens'])){
             $removefromScreens = $msg['Screens']['remove'];
             $data= array('type'=>'remove','remove'=>$msg['push']['data']);
                 foreach($removefromScreens as $key=>$value){
                     
                     if(isset($this->ripi_browser[$value])){
                        $this->ripi_browser[$value]->send(json_encode($data));
                        //echo 'Sent remove to Screenid '.$value.PHP_EOL;
                     }
                 }
         
         }
         if(array_key_exists('add',$msg['Screens'])){
             $addtoScreens = $msg['Screens']['add'];
             $data= array('type'=>'add','add'=>$msg['push']['data']);
                 foreach($addtoScreens as $key=>$value){ 
                     if(isset($this->ripi_browser[$value])){
                        $this->ripi_browser[$value]->send(json_encode($data));
                        //echo 'Sent add to Screenid '.$value.PHP_EOL;
                     }
                 }

         }
     }/*elseif($msg['type']=='refresh'){
         $from->close();
         $this->ripiClients[(string)$msg['MacAdd']]->send(json_encode($data));    
     }
 */
      //$from->close();
    }

    public function onClose(ConnectionInterface $conn) {
                // The connection is closed, remove it, as we can no longer send it messages
               // $this->ripi_browser->detach($conn);
                if(in_array($conn,$this->ripi_browser)){

                      $id = SocketController::getResourceMap($conn->resourceId);
                      echo date("F j, Y, g:i a",time()).' Screen '.$id.' disconnected at resource id '.$conn->resourceId.PHP_EOL;
                      unset( $this->macMap[$conn->resourceId]);
                      unset($this->ripi_browser[$id]);




               }  
               elseif(in_array($conn,$this->ripiClients)){

                    $MacAdd = SocketController::getResourceMap($conn->resourceId);

                    if($this->setStatus($MacAdd,'1')){

                     $data= array('type'=>'togglestatus','MacAdd'=>$MacAdd,'status'=>'1');
                     foreach ( $this->admin_browser as $users) { 
                        //if the websocket connection is closed by raspberry pi
                        //sending message to the screens index page that the raspberrypi is shutdown  
                            $users->send(json_encode($data));   
                        }

                     }

                    echo date("F j, Y, g:i a",time()).' Raspberry-pi client '.$MacAdd.' disconnected at resource id '.$conn->resourceId.PHP_EOL;

                    unset( $this->macMap[$conn->resourceId]);
                    unset($this->ripiClients[$MacAdd]);



               }elseif(in_array($conn,$this->admin_browser)){

                    echo date("F j, Y, g:i a",time())." Admin disconnected at resource id ". $conn->resourceId.PHP_EOL;
                    unset($this->admin_browser[$conn->resourceId]);

               }
               else{
                  $conn->close(); 
                  echo date("F j, Y, g:i a",time())." Connectiion closed at resource id ". $conn->resourceId.PHP_EOL;
               }
            }

    public function onError(ConnectionInterface $conn, \Exception $e) {
    echo "An error has occurred : {$e->getMessage()}\n";

    $conn->close();
    }
    /*
     * Returns the MacAddress/Id of connected client for given resourceId 
     * $Id is the id
     * $get is what we want in return MacAddress or resourceId
     */
    public function getResourceMap($Id){
        
        return $this->macMap[$Id];
        
    }
    /*public function authenticate($sessionId){
        $stmt = $this->mysqli->prepare("SELECT accesslevel FROM users WHERE sid=?");
        $stmt->bind_param('s', $sessionId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }*/
    public function setStatus($MacAdd,$statusId){
         $stmt = $this->mysqli->prepare("UPDATE screens SET status=? WHERE MacAdd=?");//updating the status to database
         $stmt->bind_param('ds', $statusId,$MacAdd);
         $stmt->execute();
         $stmt->close();
         return 'true';
    }
    public function verifyPi($MacAdd,$serialNumber){
        $stmt = $this->mysqli->prepare("SELECT ScreenId FROM screens WHERE MacAdd=? AND serialNumber=?");
        $stmt->bind_param('ss', $MacAdd,$serialNumber);
        $stmt->execute();
        $r=$stmt->get_result();
        $stmt->close();
        if( $r->num_rows === 0){
                   print_R(mysqli_fetch_assoc($stmt->get_result()));
                  return false;
        }else{
           return true;
        }
    }
    public function authenticate($sid){
       
       
       $stmt = $this->mysqli->prepare("SELECT accesslevel FROM users WHERE sid=?");
       $stmt->bind_param('s',$sid);
       $stmt->execute();
       $r=$stmt->get_result();
       $stmt->close();
       
        if( $r->num_rows === 0){
                    $stmt1 = $this->mysqli->prepare("SELECT ScreenId FROM screens WHERE sess_id=?");
                    $stmt1->bind_param('s',$sid);
                    $stmt1->execute();
                    $r1=$stmt1->get_result();
                    $stmt1->close();
                    if( $r1->num_rows === 0){
                       return false; 
                    }
                    else{
                      $sid=$r1->fetch_array(MYSQLI_ASSOC)['ScreenId'];
                       return array('ripiBrowser'=>$sid);
                    }
                  
                  
        }else{
           
           $access=$r->fetch_array(MYSQLI_ASSOC)['accesslevel'];
           
           if($access==1){
               return array('adminBrowser'=>$access);
           }else{ 
               return false;
           }
        }
    }
    
    public function getFreePort(){
            $address = '127.0.0.1';

            // Create a new socket
            $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

            // Bind the source address
            socket_bind($sock, $address);

            socket_getsockname($sock, $address, $port);

            $freeport = $port;
            socket_close($sock);
            return $freeport;
    }
    
}