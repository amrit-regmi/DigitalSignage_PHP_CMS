<?php
/* @var $this ClientController */
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/Javascript/ImageLoaded.js');

$this->breadcrumbs=array(
	'Client'=>array('/client'),
	'View',
);
// print_r($data_subscription->getData());

  $this->widget('booster.widgets.TbButton',array(
                'context' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'label'=>'Add new Subscription',
                'buttonType'=>'link',
                'url'=>yii::app()->createUrl('/Subscription/Add/'.$client_Id),
            )
          );
  echo '<div class="clearfix"></div>';?>  
<div class="col-md-7 "style="padding-left: 0px;">
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
                'url'=>yii::app()->createUrl('/Ads/Add/'.$client_Id),
            ),
        )
    )
);
?> <div class="ads" style="margin:0; padding:0;"><?php
  foreach($data_ads->getData()as $advert){
     
     echo ' <div class="panel-primary col-md-4 a" id="'.$advert->AdsId.'" ><div class="advert">
    <div class="advert_image" >
        <img class ="img-thumbnail"style = "display: table-cell; margin:auto; vertical-align:middle; "src="'.Yii::app()->getBaseUrl().$advert->Source.'">
    </div>
   <div class="advert_detail">
       <h4>'.$advert->name.'</h4>
       <p>Upload Date: '.$advert->Date.'</p>
       <a href="'.Yii::app()->urlManager->createUrl("/Ads/update/".$advert->AdsId).'" class="label label-danger">Update</a>
       <a href="'.Yii::app()->urlManager->createUrl("/Ads/".$advert->AdsId."?ref=client/".$client_Id).'" class="label label-success">View</a>    
   </div>
   <p class="text-center  text-info">Displaying On: <strong>'.$advert->occurence.' Screens '.sizeOf(Ads::getRoutes($advert->AdsId,false)).' Routes </strong> </p>
</div></div>';
      
   
   } ?>
   
  
</div>
     <?php $this->endWidget(); ?>
</div><div class="col-md-5" style="padding-right: 0px; ">
<?php 
 $this->beginWidget(
    'booster.widgets.TbPanel',
    array(
        'title' => 'Client data',
        'headerIcon' => 'user',
         'context'=>'primary',
        'padContent'=>false
    )
);
 
$this->widget(
    'booster.widgets.TbDetailView',
    array(
        'data' => Client::model()->findByPk($client_Id),
        'attributes' => array(
            array('name' => 'Name' ),
            array('name' => 'Address'),
            array('name' => 'Contact'),
        ),
    )
);

$this->endWidget();

 $this->beginWidget(
    'booster.widgets.TbPanel',
    array(
        'title' => 'Subcription',
        'headerIcon' => 'picture',
         'context'=>'primary',
        'padContent'=>false
    )
);
 $this->widget('booster.widgets.TbGridView',array(
     'dataProvider'=>$data_subscription,
     'type'=>'striped  condensed',
     'template'=>"{items}\n{pager}",
     'columns'=>array(
        array('name'=>'SubscriptionId', 'header'=>'Id'),
         array('name'=>'RouteId', 'header'=>'Route','value'=> 'Route::model()->findByPk($data->RouteId)->RouteName'),
         array('name'=>'NumScreen', 'header'=>'Number of screens'),
         array('name'=>'NumAds', 'header'=>'Number of Adverts'),
         array('name'=>'Expire', 'header'=>'Expire'),
                  array('name'=>'Status','header' =>'Status',
            'type'=>'raw',
            'value'=>function($data,$row) {
                  if($data->Status==0){
                              return "<span class=\"label label-danger\">Deactiviated</span>&nbsp;";
                              
                          }
                          else{
                              return "<span class=\"label label-success\">Active</span>&nbsp;";
                              
                          }
                         },
             ),
         array(
            'class'=>'booster.widgets.TbButtonColumn',
            'visible'=> true,
            'htmlOptions'=>array('style'=>'width: 50px'),
            'template'=>'{update}',
            //'afterDelete'=>'function(link,success,data){if(success){$("#page").prepend(data);}}',
            'buttons'=>array(
                                'update' => array(
                                 'url'=>'Yii::app()->controller->createUrl("/Subscription/update/".$data->SubscriptionId)',
                                  'visible'=>'true',
                                ),
                               
                        ),
                        

        ),
 
    )
 ));
 //Subscribedscreens::assignScreens(4,1,2);
 ?>
    
    <?php $this->endWidget(); ?>





<?php 
$this->beginWidget(
    'booster.widgets.TbPanel',
    array(
        'title' => '  Routes',
        'headerIcon' => 'road',
         'context'=>'primary',
        'padContent' => false,
        'htmlOptions' => array('class' => 'bootstrap-widget-table'),
         
        //'content' => 'My Basic Content (you can use renderPartial here too :))'
    )
);


 $this->widget('booster.widgets.TbGridView',array(
     'dataProvider'=>$data_subscription,
     'type'=>'striped  condensed',
     'template'=>"{items}\n{pager}",
     'columns'=>array(
         array('name'=>'RouteId', 'header'=>'Routes','value'=> 'Route::model()->findByPk($data->RouteId)->RouteName'),
         array('name'=>'NumScreen', 'header'=>'Num. Screens /</br> Num. allowed',
             'value'=>function($data,$row) {
                          $value =sizeof(Screens::getClientScreens($data->RouteId,$data->ClientId)).' / '.$data->NumScreen;
                           return $value;      
                         },
             
             ),
         array('name'=>'NumAds', 'header'=>'Num. of Ads',
             'value'=>function($data,$row) {
                          $value =sizeof(Assigned::getAdsinRoute($data->RouteId,$data->ClientId)).' / '.$data->NumAds;
                           return $value;      
                         },),
        array('name'=>'NumAds', 'header'=>'Num. of used space/</br> Num. allowed',
             'value'=>function($data,$row) {
                          $value =sizeof(Assigned::getAdsinRoute($data->RouteId,$data->ClientId,false)).' / '.$data->NumScreen*$data->NumAds;
                           return $value;      
                         },),
    )
 ));
 
 
 $this->endWidget();
 

 ?>

</div>


<script>
    $(document).ready(function(){
        
       $('.ads').imagesLoaded(function() {
        var my =$($("div.a")[0]);
        console.log(my.position());
       $($("div.a")[4]).css('top',$($("div.a")[1]).position().top+$($("div.a")[1]).height()+'px').css('position','absolute').css('width','31.3%').css('left',$($("div.a")[1]).position().left+'px');
       var len = $($('div.a')).length;
       var heighta =320;
       for (i = 3; i < len;i++){
           $($("div.a")[i])
                   .css('top',$($("div.a")[i-3]).position().top+$($("div.a")[i-3]).height()+10+'px')
                   .css('position','absolute')
                   .css('width','31.3%')
                   .css('left',$($("div.a")[i-3]).position().left+'px');
                   heighta =  $($("div.a")[i]).offset().top+$($("div.a")[i]).height();

        }
        console.log($('.a :last').offset().top + $('.a :last').height()+ 15+'px');
        
         $('.ads').css('height',heighta +'px');
        });      
});
	
</script>

