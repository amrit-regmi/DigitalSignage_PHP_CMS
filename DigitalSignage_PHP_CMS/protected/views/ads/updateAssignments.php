<?php 
$data = Subscription::getSubscribedRoutes($client_Id);
$list = CHtml::listData($data,'RouteId','route.RouteName');

  
//$ndata = Subscription::getAvailableScreens('1','1');
//print_r($data);

$form = $this->beginWidget(
	'booster.widgets.TbActiveForm',
	array(
		'id' => 'Ads',
		'type' => 'horizontal',
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    'clientOptions' => array(
        'validateOnSubmit'=>true,
        'validateOnChange'=>false,
        'validateOnType'=>false,

    ),
	)
);

echo $form->hiddenField($model,'ClientId',array('value'=>$client_Id)); 
?>
<div>
    
    <?php if (empty($assignedData)){ ?>
           <table class="table table-condensed detail"><tr class="reference"><td><?php echo $form->dropDownListGroup(
			$model,
			'RouteId[]',
			array(  'label' =>'Route',
				'wrapperHtmlOptions' => array(
				
				),
				'widgetOptions' => array(
					'data' => $list,
					'htmlOptions' => array('id'=>'Ads_RouteId','prompt'=>'-- SELECT A ROUTE --','required'=>'required'),
				)
			)
        ); ?> </td><td><?php echo $form->textFieldGroup(
			$model,'NumScreens[]',
			array(
                            'label' =>'Number of Screens',
				'wrapperHtmlOptions' => array(		
				),
                            'widgetOptions' => array(
					'htmlOptions' => array('disabled' => true,'placeholder'=>'Enter number of screens','required'=>'required' ,'type'=>'number'),
				)
				
			)
                );?></td><td>Max Allowed</td></tr>

</table> 
        
    <?php } else { ?>
    



    
<table class="table table-condensed detail">
     <?php    
     foreach ($assignedData as $key => $value) {
    echo '<tr class="reference">'
         . '<td>' .$form->dropDownListGroup(
			$model,
			'RouteId[]',
			array(  'label' =>'Route',
				'wrapperHtmlOptions' => array(
				
				),
				'widgetOptions' => array(
					'data' => $list,
					'htmlOptions' => array('id'=>'Ads_RouteId','options' => array($value['RouteId']=>array('selected'=>true)),'required'=>'required'),
				)
			)
        ).' </td>'
         . '<td>'.$form->textFieldGroup(
			$model,'NumScreens[]',
			array(
                            'label' =>'Number of Screens',
				'wrapperHtmlOptions' => array(		
				),
                            'widgetOptions' => array(
					'htmlOptions' => array('class'=>'Ads_NumScreens','placeholder'=>'Enter number of screens','required'=>'required' ,'type'=>'number','value'=>$value['NumScreen']),
				)
				
			)
     ).'</td>'
            . '<td id="max">Max Allowed '.Subscription::getAvailableScreens($value['RouteId'],$client_Id,$model->AdsId).'</td>';
    if($key != 0){
        echo '<td><button class="btn btn-danger btn-xs" id="btn_remove" name="yt0" type="button">Remove</button></td>';
    }
    echo '</tr>';
    
    
     }
    }?>

</table>
<?php $this->beginWidget('booster.widgets.TbButton',
        array(
            'id'=>'btn_add',
            'label'=>'Add Another',
            
            'size'=>'extra_small'
        )); 
    $this->endWidget();
    ?>
    </div> 
<div class="form-actions" style="margin-top:10px;"></div>
        <?php

    $this->beginWidget(
    'booster.widgets.TbButton',
    array('buttonType' =>'submit','context' => 'success','label' => 'Save',
         'htmlOptions' => array(
					'class' => 'col-sm-3',
                                    
				),)
    );
    $this->endWidget();

$this->beginWidget(
    'booster.widgets.TbButton',
    array('context' => 'primary','label' => 'Cancel',
         'htmlOptions' => array(
					'class' => 'col-sm-3',
                                        'id'=>'cancel',
                                    
				),)
    );
    $this->endWidget();
?>
</div>

<?php $this->endWidget();

?>
<style>
    #Ads_NumScreens{
        color:black;
        height:35px;
        padding-left:15px;
    }
</style>
<script>
    
    
     var routes = <?php echo json_encode($list) ?>;
     var clientId = <?php echo $client_Id ?>;
        
     $('.Ads_NumScreens').each(function(index, data) {
         var val = $(this).val();
         var max = $(this).closest("tr").find('td:eq(2)').html().replace( /^\D+/g, '');
         $(this).replaceWith('<input class="numscreen" type="number" name="Ads[NumScreens][]" id="Ads_NumScreens" min="1" max='+max+' value ='+val+' required>');
  
        });
    
    var count = Object.keys(routes).length- $('.numscreen').length;
    if(count<=0){
        $("#btn_add").attr('disabled','disabled');
    } 
    
    
     $(".table").on('click', "#btn_remove", function (event) {
        $(this).closest("tr").remove();
        count++;
        $("#btn_add").removeAttr('disabled');
    });
    
    
    
    $("#btn_add").on("click", function () {
        var row = $(".reference:first").clone().find("input").attr('value',"").end();
        row.show();
        
        //var lastrow=$("table tr:last").find(".Ads_RouteId").val();
        //console.log(lastrow);
        
        var col = '<td><button class="btn btn-danger btn-xs" id="btn_remove" name="yt0" type="button">Remove</button></td>';  
        row.append(col); 
        row.appendTo(".detail");
        
        
        count--;
        
      
        if(count<=0){
        $("#btn_add").attr('disabled','disabled');
    } 
    
 
    //$("#Ads_RouteId option[value="+1+"]").not($("#Ads_RouteId:first")).remove();
   // t = $("table tr:last").find("#Ads_RouteId");
  
    
    });
    $("#cancel").on("click",function(){
        console.log('click');
        $('#popbox').css("visibility","hidden");
    });
       
        $(document).on('change',"#Ads_RouteId",function(){
        $(this).closest("tr").find("input").attr('disabled','disabled');
    
        $.ajax({url:"<?php echo Yii::app()->urlManager->createUrl("/Ads/AjaxAvailable")?>",
        data: "routeId="+$(this).val()+"&clientId="+clientId+"&AdsId="+<?php echo $model->AdsId ?>,
        context: this,
        success:function(result){
            
            $(this).closest("tr").find('td:eq(2)').html('Max Allowed: '+result);
                        $(this).closest("tr").find("input").replaceWith('<input type="number" name="Ads[NumScreens][]" id="Ads_NumScreens" min="1" max='+result+' required>');
  }});
});
    

</script>