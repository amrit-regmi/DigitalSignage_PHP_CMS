<?php
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/Javascript/ImageLoaded.js');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->breadcrumbs=array(
	'Screens'=>array('/screens'),
	$screen->ScreenId=>array('/screens/'.$screen->ScreenId),
); 
 
$this->widget(
    'booster.widgets.TbButton',
    array(
        'buttonType'=>'link',
        'label' => 'Update Screen',
        'context' => 'primary',
        'url'=> Yii::app()->controller->createUrl('/Screens/Update/'.$screen->ScreenId),
    )
); echo ' ';

?><div id="notification-anchor"></div><div id ="notification"></div>

    <?php
if($screen->Status==0){
  $title=  'Control Panel  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; !!Screen is not available at the moment!!';
  $context = 'danger';
}else if($screen->Status==2){
  $title=  'Control Panel';
  $context = 'success';
}else{
    $title=  'Control Panel  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Network error,Screen is Offline!';
  $context = 'warning';
}
$this->beginWidget(
    'booster.widgets.TbPanel',
    array(
        'title' => $title,
        'context' => $context,
        'headerIcon' => 'cog',
        'htmlOptions'=>array('id'=>'control'),
    )
);

?>
<div class="my_alert" ></div>
<div class ="cmd_loading" ><p class="cmd_txt">Connecting to Screen...</p></div><div class="container home">
    
    <div class="row">
        <div class="col-lg-4">
            <i class="glyphicon glyphicon-home"></i> <?php echo $screen->ScreenName; ?>
        </div>
        <div class="col-lg-4">
            <i class="glyphicon glyphicon-road"></i> <?php echo Route::model()->findbyPk($screen->RouteId)->RouteName; ?>
        </div>
        <div class="col-lg-4">
            <i class="glyphicon glyphicon-play-circle"></i> Number of Adverts: <?php echo'<span style="color: blue">'.COUNT($ads->getData())."</span>"; ?>
        </div>
         
    </div>
    <div class="row">
        <div class="col-lg-4">
            <i class="glyphicon glyphicon-time"></i><span id="uptime">Uptime<span class="loading"></span></span>		        
        </div>		
    </div>

   
    <div class="row">
        <div class="col-lg-5">
            <div class="row">
                <i class="glyphicon glyphicon-map-marker"></i> <?php echo Screens::formatMac($screen->MacAdd); ?>
            </div>
            <div class="row">
                <i class="glyphicon glyphicon-asterisk"></i> <span id="ram"> Ram </span><span style ="color:green" id="ramfree"><span class="loading"></span></span><span style ="color:red" id="ramused"></span><span style ="color:blue" id="ramtotal"></span>
            </div>
            <div class="row">
                <i class="glyphicon glyphicon-tasks"></i><span id="cpuload">Cpuload :<span class="loading"></span></span>
            </div>
            <div class="row">
                <i class="glyphicon glyphicon-fire"></i><span id="cputemp">CPU temprature : <span class="loading"></span></span>
            </div>
        </div>
        <div class="col-lg-4">
            <div class='row'>
                <i class="glyphicon glyphicon-hdd"></i><span id="storage"> Storage </span><span style ="color:green" id="storagefree"><span class="loading"></span></span><span style ="color:red" id="storageused"></span><span style ="color:blue" id="storagetotal"></span>
            </div>
            <div class='row'>
               <a href=" "><i class="glyphicon glyphicon-globe"></i> Bandwidth Usage</a>
               <div><i class="glyphicon glyphicon-cloud-upload"></i><span id="tx">tx<span class="loading"></span></span></div>
               <div><i class="glyphicon glyphicon-cloud-download"></i><span id="rx">rx<span class="loading"></span></span></div>
            </div>
            <div class='row'>
                <div class='col-lg-3' > <button  class="btn btn-danger" disabled="disabled" id="shutdown"><span class="glyphicon glyphicon-off" style="vertical-align:middle; font-size: 2em;"></span></button></div>
                <div class='col-lg-3'> <button class="btn btn-info" disabled="disabled" id="reboot" ><span class="glyphicon glyphicon-refresh" style="vertical-align:middle; font-size: 2em;"></span></button></div>
                <div class='col-lg-3'> <button class="btn btn-info" disabled="disabled" id="opencon" ><span class="glyphicon glyphicon-log-in" style="vertical-align:middle; font-size: 2em;"></span></button></div>
            </div>
        </div>
    </div>
</div>
<?php
$this->endWidget();?>
  
           <div class="col-md-12 "style="padding: 0px;">
  <?php 

 
  $this->beginWidget(
    'booster.widgets.TbPanel',
    array(
        'title' => '  Adverts',
        'headerIcon' => 'picture',
         'context'=>'primary',
        'headerButtons' => array(
            array(
                'class' => 'booster.widgets.TbButton',
                'context' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'label'=>'Add new Advert',
                'buttonType'=>'link',
                'url'=>yii::app()->createUrl('/Screens/AddAds/'.$screen->ScreenId),
            ),
        )
    )
);
?> <div class="ads" style="margin:0; padding:0;"><?php
  foreach($ads->getData() as $advert){
     
     echo ' <div class="panel-primary col-md-3 a" id="'.$advert->AdsId.'" ><div class="advert">
    <div class="advert_image" >
        <img class ="img-thumbnail"style = "display: table-cell; margin:auto; vertical-align:middle; "src="'.Yii::app()->getBaseUrl().$advert['ads']->Source.'">
    </div>
   <div class="advert_detail">
       <h4>'.$advert['ads']->name.'</h4>
       <p>Upload Date: '.$advert['ads']->Date.'</p>
       <a href="'.Yii::app()->urlManager->createUrl("/Ads/".$advert->AdsId."?ref=Screens/".$screen->ScreenId).'" class="label label-success">View</a>    
   </div>
   <p class="text-center  text-info">Displaying On: <strong>'.$advert['ads']->occurence.' Screens '.sizeOf(Ads::getRoutes($advert->AdsId,false)).' Routes </strong> </p>
</div></div>';
      
   
   } ?>
   
  
     <?php $this->endWidget(); ?>
</div>
<style>
.sticky {
    position: fixed;
    top: 0;
    right:0;
    z-index: 10000;
}
</style>               
<script>
     
  $(document).ready(function(){
    
  
    var ws = new WebSocket("wss://sastotest.info:9000/");
     ws.onopen = function()
     {
         console.log('connected');
       ws.send('{"type":"request","cmd":"getSysteminfo","MacAdd":"<?php echo $screen->MacAdd?>"}');
     };
     ws.onmessage = function(evt){
         
         //console.log(msg)
         var msg = JSON.parse(evt.data);
         console.log(msg)
         if(msg.type==='response'){
         //console.log(msg);
         $("#control").removeClass();
         $("#control").addClass("panel panel-success");
         $("#control").find(".panel-title").html('Control Panel');
         $("#shutdown").prop('disabled', false);
         $("#reboot").prop('disabled', false);
         $("#opencon").prop('disabled', false);
         
         var $uptime = secondsToTime(msg.response.uptime);
         var totalram= Math.floor(msg.response.ram[0]/1024);
         var usedram = Math.floor(msg.response.ram[1]/1024);
         var freeram =Math.floor(msg.response.ram[2]/1024);
         var storagetotal = msg.response.storage[0];
         var storageused= msg.response.storage[1];
         var storagefree = msg.response.storage[2]
         //var storageusedpercent = msg.response.storage[3];
         var cpuload = msg.response.cpu;
         var cputemp= msg.response.cputemp;
         var tx = (msg.response.bandwidth[0]/1048576).toFixed(2);
         var rx = (msg.response.bandwidth[1]/1048576).toFixed(2);
         
         $('#uptime').text($uptime);
         $('#ramfree').text(freeram+"Mb Free ");
         $('#ramtotal').text(totalram+"Mb Total ");
         $('#ramused').text(usedram+"Mb Used ");
         $('#cpuload').text("Cpuload: "+ cpuload +"%");
         $('#cputemp').text("Cpu Temprature: "+ cputemp + " 'C")
         $('#storagefree').text(storagefree + "b Free ");
         $('#storageused').text(storageused +"b Used ");
         $('#storagetotal').text(storagetotal +"b Total ");
         $('#tx').text(" "+tx+ " Mb");
         $('#rx').text(" "+rx+ " Mb");
     }
      if(msg.type=="togglestatus" && msg.MacAdd == "<?php echo $screen->MacAdd; ?>") {
           toggle = msg.status;
           //console.log(msg);
            
            switch(toggle){
                case '0':
                   $("#control").removeClass();
                   $("#control").addClass("panel panel-danger");
                   $("#control").find(".panel-title").html('Control Panel  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; !!Screen is not available at the moment!!');
                   $("#shutdown").prop('disabled', true);
                   $("#reboot").prop('disabled', true);
                   $("#opencon").prop('disabled', true);
                   $(".cmd_txt").css('color','red').text('Screen Shutting Down');
                        var tId;
                        clearTimeout(tId);
                        tId=setTimeout(function(){
                            $(".cmd_loading").hide();
                            $('<div class="my alert in fade alert-danger" ><a href="#" class="close" data-dismiss="alert">×</a>Screen gracefully shutdown</div>').appendTo("#notification");
                             $(".cmd_txt").text('Connecting to Screen...');
                        }, 5000)
                    break;
                    break;
                case '1':
                    $("#control").removeClass();
                    
                    $("#control").addClass("panel panel-warning");
                    
                     tId=setTimeout(function(){
                            $(".cmd_loading").hide();
                            $('<div class="my alert in fade alert-warning" ><a href="#" class="close" data-dismiss="alert">×</a>Network Error, Screen is Offline</div>').appendTo("#notification"); 
                        }, 5000)
                    $("#shutdown").prop('disabled', true);
                    $("#reboot").prop('disabled', true);
                    $("#opencon").prop('disabled', true);
                    

                    break; 
                case'2':    
                    $("#control").removeClass();
                    $("#control").addClass("panel panel-success");
                    $("#control").find(".panel-title").html('Control Panel');
                    ws.send('{"type":"request","cmd":"getSysteminfo","MacAdd":"<?php echo $screen->MacAdd?>"}');
                    $('<div class="my alert in fade alert-success" ><a href="#" class="close" data-dismiss="alert">×</a>Screen is Online</div>').appendTo("#notification");
                    
                    break;
               case'3':    
                    $("#control").removeClass();
                    $("#control").addClass("panel panel-warning");
                    $("#control").find(".panel-title").html('Control Panel');
                    $(".cmd_txt").css('color','red').text('Screen is shutting down');
                    tId=setTimeout(function(){
                            $(".cmd_loading").hide();
                            $('<div class="my alert in fade alert-success" ><a href="#" class="close" data-dismiss="alert">×</a>Screen is Shut down</div>').appendTo("#notification");
                        }, 5000)
                    
                     
                    break;
            }
            
       
        }
        if(msg.type=="ack" && msg.MacAdd == "<?php echo $screen->MacAdd;?>" ){
            console.log(msg);
            toggle = msg.ack;
            switch(toggle){
                case '0':
                        var tId;
                        clearTimeout(tId);
                        tId=setTimeout(function(){
                            $(".cmd_loading").hide();
                            $('<div class="my alert in fade alert-danger" ><a href="#" class="close" data-dismiss="alert">×</a>Network Error, Screen cannot be reached, Please try again</div>').appendTo("#notification");
                        }, 5000)
                    break;
                    
                case '1':
                port=msg.info;
                $(".cmd_txt").css('color','green').text('Connection established, it may take some time , please wait');
                           setTimeout(function(){
                               if($(".cmd_loading").is(':visible')){
                                   console.log('unnn');
                                    $(".cmd_loading").hide();
                                    if(port!=null){
                                        $('<div class="my alert in fade alert-warning" ><a href="#" class="close" data-dismiss="alert">×</a>It took too long to respond, try connectiong to port '+port+'  or try again</div>').appendTo("#notification");
                                    }else{
                                        
                                        $('<div class="my alert in fade alert-warning" ><a href="#" class="close" data-dismiss="alert">×</a>It took too long to respond,please try again</div>').appendTo("#notification");
                                }
                            } 
                            },25000)
                    break;
                    
            case '2':
                    port=msg.info;
                       
                    $(".cmd_loading").hide();
                    $('<div class="my alert in fade alert-success" ><a href="#" class="close" data-dismiss="alert">×</a>Tunnel established, open the ssh client application and connect at port number '+port+'</div>').appendTo("#notification");
                    break;
            }
        
        
        
        }
         //console.log(secondsToTime(uptime));
         
        };

   $('#shutdown').click(function(){
     //console.log("shut");
        $(".cmd_loading").show();
         ws.send('{"type":"cmd","cmd":"shutdown","MacAdd":"<?php echo $screen->MacAdd?>"}');
        
     })
   $('#reboot').click(function reboot(){
      // console.log("rebot");
         $(".cmd_loading").show();
         ws.send('{"type":"cmd","cmd":"reboot","MacAdd":"<?php echo $screen->MacAdd?>"}');
          
      
  });
   $('#opencon').click(function openCon(){
      //console.log("onclick");
      $(".cmd_loading").show();
         ws.send('{"type":"cmd","cmd":"openTunnel","MacAdd":"<?php echo $screen->MacAdd?>"}');
         
     });
            $('.ads').imagesLoaded(function() {
          var my =$($("div.a")[0]);
          
         $($("div.a")[4]).css('top',$($("div.a")[1]).position().top+$($("div.a")[1]).height()+'px').css('position','absolute').css('width','31.3%').css('left',$($("div.a")[1]).position().left+'px');
         var len = $($('div.a')).length;
         var heighta = 320;

         for (i = 4; i < len;i++){
             $($("div.a")[i])
                     .css('top',$($("div.a")[i-4]).position().top+$($("div.a")[i-4]).height()+10+'px')
                     .css('position','absolute')
                     .css('width','24%')
                     .css('left',$($("div.a")[i-4]).position().left+'px');
                      heighta =  $($("div.a")[i]).offset().top+$($("div.a")[i]).height();

          }
          

         $('.ads').css('height',heighta+'px');
          });
           function secondsToTime(secs)
        {
            var hours = Math.floor(secs / (60 * 60));

            var divisor_for_minutes = secs % (60 * 60);
            var minutes = Math.floor(divisor_for_minutes / 60);

            var divisor_for_seconds = divisor_for_minutes % 60;
            var seconds = Math.ceil(divisor_for_seconds);
            
            return "  "+hours+ " hours " + minutes + " minutes " + seconds+" seconds";
        };
        function sticky_relocate() {
            var window_top = $(window).scrollTop();
            var div_top = $('#notification-anchor').offset().top;
            if (window_top > div_top) {
                $('#notification').addClass('sticky');
            } else {
                $('#notification').removeClass('sticky');
            }
        }

        $(function () {
            $(window).scroll(sticky_relocate);
            sticky_relocate();
        });
     

  }
      
           
      );
  
   
       
            

            
    </script>



