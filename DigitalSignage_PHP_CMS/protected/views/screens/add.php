<?php 
 $this->breadcrumbs=array(
	'Screens'=>array('/screens'),
	'Add',
);?>
<div id="notification"></div>
<div id="field">
<?php $this->beginWidget(
    'booster.widgets.TbJumbotron',
    array(
        'heading' => 'Please connect the Raspberry Pi',
    )
); ?>
 
    <p>If the raspberry pi is already connected the system will automatically detect the connected raspberry pi in a while. Please make sure
    that the raspberry pi is powered on and connected to internet.<a href="#" id ="ajaxbuttona" class=" btn btn-warning" >Click here if you want to add manually.</a></p>
 
    <p>
<?php $this->endWidget();


?>
        </div>
<script>
  var unverified = new Array; 
  var rid;
  <?php if(isset($_GET['rid'])){
             echo "rid = ".$_GET['rid'].";"; }?>;
  $(document).ready(function(){
      console.log(rid+'1');
    var ws = new WebSocket("wss://sastotest.info:9000/");
     ws.onopen = function()
     {
         console.log('connected');
       
     };
     ws.onmessage = function(evt){
         
         //console.log(msg)
         var msg = JSON.parse(evt.data);
         if(msg.type==='verification' && ($.inArray(msg.MacAdd,unverified)) < 0) {
            console.log(msg);
            $('<div class="my alert in fade alert-success" ><a href="#" class="close" data-dismiss="alert">× Not this</a><p>Raspberry pi attempting to connect </P><ul><li>MacAddress: <span id="macadd">'+msg.MacAdd+'</span></li><li>Serial: <span id="serial">'+msg.serial+'</span></li></ul>\n\
              <a href="#" id="ajaxbuttont" class=" btn btn-warning" >Click here To add this raspberry pi to system</a></div>').appendTo("#notification");
            unverified.push(msg.MacAdd);
        }
         
          $("#ajaxbuttont").on("click",function(){
            
            var macadd= $(this).parent('div').find("#macadd").html();
            var serial= $(this).parent('div').find("#serial").html();

                  $.ajax({
                   type: "POST",
                   url:"<?php echo Yii::app()->urlManager->createUrl("/Screens/Add")?>",
                    data: {ajax:"addScreen",MacAdd:macadd,Serial:serial,rid:rid},
                    context: this,
                   success:function(result){
                       //$(result).appendTo(".my");
                       $(this).parent('div').html('<a href="#" class="close" data-dismiss="alert">× Not this</a>'+result);
                    }});
          }); 
         
         
        }
         $("#ajaxbuttona").on("click",function(){
           
                  $.ajax({
                   type: "POST",
                   url:"<?php echo Yii::app()->urlManager->createUrl("/Screens/Add")?>",
                  data: {ajax:"addScreen",rid:rid},
                  context: this,
                   success:function(result){
                       $("#field").html(result);
                    }});
          });  
        
        
        
     }
         )
 </script>
     