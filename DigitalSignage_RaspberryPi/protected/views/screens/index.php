<?php
/* @var $this ScreensController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Screens',
);


?>


<?php 


$this->widget('booster.widgets.TbButton',
	array( 'buttonType'=>'link','label'=>'Add New Screen','context'=>'primary','url'=>yii::app()->createUrl('/Screens/Add')));
	//array('label'=>'Manage Screens', 'url'=>'admin'),); ?>

<?php $this->widget('booster.widgets.TbGridView', array(
    'type'=>'striped bordered condensed',
    'dataProvider'=>$data,
    'template'=>"{items}",
    'columns'=>array(
        array('name'=>'ScreenName', 'header'=>'Screen Name',
            'value'=>'CHtml::link($data->ScreenName,Yii::app()->urlManager->createUrl("/Screens/".$data->ScreenId),array(\'style\'=>\'display:block;width:100%\'))', 
            'type'=>'raw'
            ),
        array('name'=>'MacAdd', 'header'=>'MAC Address'),
        array('name'=>'RouteId', 'header'=>'Route'),
        array('name'=>'Status','header' =>'Status',
            'type'=>'raw',
            'value'=>function($data,$row) {
                  if($data->Status==2){
                         return "<span id=".$data->MacAdd." class=\"label label-success\">Active</span>&nbsp;";             
                          }
                    elseif($data->Status==0){ 
                              return "<span id=".$data->MacAdd." class=\"label label-danger\">Shut down</span>&nbsp;";
                              
                          }
                          else{
                              return "<span id=".$data->MacAdd." class=\"label label-warning\">Unreachable</span>&nbsp;";
                              
                          }
                         },
             ),
          array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'visible'=> true,
            'htmlOptions'=>array('style'=>'width: 50px'),
            'template'=>'{update}{delete}',
            //'afterDelete'=>'function(link,success,data){if(success){$("#page").prepend(data);}}',
            'buttons'=>array(
                                'update' => array(
                                  'url'=>'Yii::app()->controller->createUrl("/screens/update/".$data->ScreenId)',
                                  'visible'=>'true',
                                ),
                               'delete' => array(
                                    'url'=>'Yii::app()->controller->createUrl("/screens/remove/".$data->ScreenId)',
                                    'visible'=>'true',
                                )
                        ),
                        

        ),
    ),
)); ?>
<script>
    $(document).ready(function(){
    if ("WebSocket" in window)
  {

     // Let us open a web socket
     var ws = new WebSocket("wss://sastotest.info:9000/");
     ws.onopen = function()
     {
         ws.send('{"type":"browser","page":"screen_idx"}');
       /* ws.send("Message to send");
        alert("Message is sent...");*/
     }
     ws.onmessage = function (evt) 
     { 
        var msg = $.parseJSON(evt.data);
        console.log(msg);
        
        
        if(msg.type=="togglestatus") {
            toggle = msg.status;
           console.log(msg.type);
            
            switch(toggle){
                case '0':
                    $("#"+msg.MacAdd).removeClass();
                    $("#"+msg.MacAdd).addClass("label label-danger");
                    $("#"+msg.MacAdd).html("Shut down")
                    break;
                case '1':
                    $("#"+msg.MacAdd).removeClass();
                    $("#"+msg.MacAdd).addClass("label label-warning");
                    $("#"+msg.MacAdd).html("Unreachable")
                    break; 
                case'2':    
                    $("#"+msg.MacAdd).removeClass();
                    $("#"+msg.MacAdd).addClass("label label-success");
                    $("#"+msg.MacAdd).html("Active")
                    break;
            }
            
       
        }     
     }
     ws.onclose = function()
     { 
        // websocket is closed.
        console.log("Connection is closed...");
       // console.log(msg);
     };
     
  }
  else
  {
     // The browser doesn't support WebSocket
     alert("WebSocket NOT supported by your Browser!");
  }
    });
    </script>