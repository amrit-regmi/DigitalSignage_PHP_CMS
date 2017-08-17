<?php
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/Javascript/ImageLoaded.js');
// set and get session attributes
//$session->set('name', 'Drak');

/* @var $this RouteController */
$this->breadcrumbs=array(
	'Route'=>array('/route'),
	$route->RouteName=>array('/route/'.$route->RouteId),
  
);

$this->widget('booster.widgets.TbButton',
	array( 'buttonType'=>'link','label'=>'Add new Screen','context'=>'primary','url'=>yii::app()->createUrl('/Screens/Add?rid='.$route->RouteId)));
	//array('label'=>'Manage Screens', 'url'=>'admin'),);


?>
<div class="clearfix"></div>    
<div class="panel panel-primary col-md-3 col-md-offset-0" ><p class="text-center h3">Active Screens</p><p class="text-center h1" ><b id="status"><?php echo count($activedata->getdata())."/".count($datas->getdata());?></b></p></div>
<div class="panel panel-primary col-md-4 col-md-offset-1"><p class="text-center h3">Adverts Displaying</p><p class="text-center h1"><b><?php echo count($ads);?></b></p></div>
<div class="panel panel-primary col-md-3 col-md-offset-1"><p class="text-center h3">Clients Subscribed</p><p class="text-center h1"><b><?php echo count($client->getdata());?></b></p></div>

    
<?php

?> <div class="clearfix "></div>
    <div  class="col-md-7" style="padding-left: 0px;"><?php
$this->beginWidget(
    'booster.widgets.TbPanel',
    array(
        'title' => '  Screens',
        'headerIcon' => 'road',
        'context' => 'primary',
        'padContent' => false,
        'htmlOptions' => array('class' => 'bootstrap-widget-table'),
        'headerButtons' => array(
            array(
                  'buttonType'=>'link',
                'class' => 'booster.widgets.TbButton',
                // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'label'=>'Add new Screen','url'=>yii::app()->createUrl('/Screens/Add?rid='.$route->RouteId),
                'context'=>'primary',
            ),
        //'content' => 'My Basic Content (you can use renderPartial here too :))'
    )
        )
);

?>


<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped condensed',
    
    'dataProvider'=>$datas,
    'template'=>"{items}\n{pager}",
    'columns'=>array(
        array(
            'value'=>'CHtml::link($data->ScreenName,Yii::app()->urlManager->createUrl("/Screens/".$data->ScreenId),array(\'style\'=>\'display:block;width:100%\'))', 
            'header'=>"Screen",
            'name'=>"ScreenId",
            'type'=>'raw',
        ),
	array(
          'name'=>'MacAdd',
          'header'=>'Mac Address',
        ),
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
)); 
$this->endWidget(); ?>
</div>
<div  class="col-md-5" style="padding-right: 0px;"> <?php                      
  $this->beginWidget(
    'booster.widgets.TbPanel',
    array(
        'title' => 'Subscribed clients',
        'headerIcon' => 'user',
        'context' => 'primary',
        'padContent' => false,
        'htmlOptions' => array('class' => 'bootstrap-widget-table'),
    
        )
);
                 
   $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped condensed',
    'dataProvider'=>$client,
       'columns'=>array(
           array(
               'header'=>'ClientName',
               'value'=>function($data,$row) {return Chtml::link($data->client->Name,yii::app()->createUrl('/Client/'.$data->ClientId));},
               'type'=>'raw',
           ),
           array(
               'header'=>'NumScreens',
               'name'=>'NumScreen',
               
           ),
           array(
               'header'=>'NumAds',
              'name'=>'NumAds',
           ),
            array(
               'header'=>'Expire',
              'name'=>'Expire',
           )
                       
       )

)); 
  
  
               $this->endWidget(); ?></div>


                  
               <div class="clearfix "></div>   
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
                'url'=>yii::app()->createUrl('/Route/AddAds/'.$route->RouteId),
            ),
        )
    )
);
?> <div class="ads" style="margin:0; padding:0;"><?php
  foreach($ads as $advert){
     
     echo ' <div class="panel-primary col-md-3 a" id="'.$advert->AdsId.'" ><div class="advert">
    <div class="advert_image" >
        <img class ="img-thumbnail"style = "display: table-cell; margin:auto; vertical-align:middle; "src="'.Yii::app()->getBaseUrl().$advert->Source.'">
    </div>
   <div class="advert_detail">
       <h4>'.$advert->name.'</h4>
       <p>Upload Date: '.$advert->Date.'</p>
       <a href="'.Yii::app()->urlManager->createUrl("/Ads/".$advert->AdsId."?ref=route/".$route->RouteId).'" class="label label-success">View</a>    
   </div>
   <p class="text-center  text-info">Displaying On: <strong>'.$advert->occurence.' Screens '.sizeOf(Ads::getRoutes($advert->AdsId,false)).' Routes </strong> </p>
</div></div>';
      
   
   } ?>
   
  
</div>
     <?php $this->endWidget(); ?>
</div>
               
               

               

<script>
    $(document).ready(function(){
      console.log();
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
                    $("#"+msg.MacAdd).html("Shut down");
                    $("#status").html(parseInt(($("#status").html()).split('/')[0])-1+'/'+($("#status").html()).split('/')[1]);
                    break;
                case '1':
                    $("#"+msg.MacAdd).removeClass();
                    $("#"+msg.MacAdd).addClass("label label-warning");
                    $("#"+msg.MacAdd).html("Unreachable")
                    break; 
                case'2':    
                    $("#"+msg.MacAdd).removeClass();
                    $("#"+msg.MacAdd).addClass("label label-success");
                    $("#"+msg.MacAdd).html("Active");
                    $("#status").html(parseInt(($("#status").html()).split('/')[0])+1+'/'+($("#status").html()).split('/')[1]);
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
  
 $('.ads').imagesLoaded(function() {
        var my =$($("div.a")[0]);
        console.log(my.position());
      
       var len = $($('div.a')).length;
      var heighta=320;
       for (i = 4; i < len;i++){
           $($("div.a")[i])
                   .css('top',$($("div.a")[i-4]).position().top+$($("div.a")[i-4]).height()+10+'px')
                   .css('position','absolute')
                   .css('width','24%')
                   .css('left',$($("div.a")[i-4]).position().left+'px');
                   heighta =  $($("div.a")[i]).offset().top+$($("div.a")[i]).height();

        }
        console.log(heighta);
        
       $('.ads').css('height',heighta +'px');
        });         
  
    });
    </script>
