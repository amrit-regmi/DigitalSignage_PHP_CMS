<?php
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/Javascript/ImageLoaded.js');
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>



           <div class="clearfix "></div>   
                <div class="col-md-12 "style="padding: 0px;">
  <?php 

 
  $this->beginWidget(
    'booster.widgets.TbPanel',
    array(
        'title' => '  Latest Adverts',
        'headerIcon' => 'picture',
         'context'=>'primary',
        
    )
);
?> <div class="ads" style="margin:0; padding:0;"><?php
  foreach($alladverts->getdata() as $advert){
     
     echo ' <div class="panel-primary col-md-3 a" id="'.$advert->AdsId.'" ><div class="advert">
    <div class="advert_image" >
        <img class ="img-thumbnail"style = "display: table-cell; margin:auto; vertical-align:middle; "src="'.Yii::app()->getBaseUrl().$advert->Source.'">
    </div>
   <div class="advert_detail">
       <h4>'.$advert->name.'</h4>
       <p>Upload Date: '.$advert->Date.'</p>
       <a href="'.Yii::app()->urlManager->createUrl("/Ads/".$advert->AdsId."/?ref=site").'" class="label label-success">View</a>    
   </div>
   <p class="text-center  text-info">Displaying On: <strong>'.$advert->occurence.' Screens '.sizeOf(Ads::getRoutes($advert->AdsId,false)).' Routes </strong> </p>
</div></div>';
      
   
   } ?>
   
  
</div>
     <?php $this->endWidget(); ?>
</div>
               
               

               

<script>
    $(document).ready(function(){

  
 $('.ads').imagesLoaded(function() {
        var my =$($("div.a")[0]);
        console.log(my.position());
       $($("div.a")[4]).css('top',$($("div.a")[1]).position().top+$($("div.a")[1]).height()+'px').css('position','absolute').css('width','31.3%').css('left',$($("div.a")[1]).position().left+'px');
       var len = $($('div.a')).length;
        var heighta=10;
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
  
    });
    </script>
