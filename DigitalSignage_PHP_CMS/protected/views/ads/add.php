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
echo $form->textFieldGroup(
			$model,'name',
                        array(  
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
                                    
				),
                            'widgetOptions' => array('htmlOptions' => array('required'=>'required'),)
				
			)
		);
 echo $form->datePickerGroup(
			$model,
			'Expires',
			array(
				'widgetOptions' => array(
                                   
					'options' => array(
                                             'format' => 'yyyy-mm-dd',
                                'viewformat' => 'yyyy-mm-dd',
						'language' => 'en',
					),
				),
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				
				'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
			)
		);
echo $form->fileFieldGroup($model, 'Source',
			array(  
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
                            'widgetOptions' => array('htmlOptions' => array('accept'=>"image/*"),)
			)
		);


    ?>
<div>
<table class="table table-condensed"><tr><td><?php echo $form->dropDownListGroup(
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
					'htmlOptions' => array('class'=>'numscreen','disabled' => true,'placeholder'=>'Enter number of screens','required'=>'required' ,'type'=>'number'),
				)
				
			)
                );?></td><td>Max Allowed</td></tr>

</table>
<?php $this->beginWidget('booster.widgets.TbButton',
        array(
            'id'=>'btn_add',
            'label'=>'Add Another',
            'context'=>'info',
            'size'=>'extra_small'
        )); 
    $this->endWidget();
?>
    </div>
<div class="form-actions">
        <?php

    $this->beginWidget(
    'booster.widgets.TbButton',
    array('buttonType' =>'submit','label' => 'Submit')
    );
    $this->endWidget();
?>
</div>

<?php $this->endWidget();

?>
<script>
    
    $(document).ready(function(){
     var routes = <?php echo json_encode($list) ?>;
     var clientId = <?php echo $client_Id ?>;
     //console.log(routes);
    
    var count = Object.keys(routes).length;
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
        var row = $("table tr:first").clone().find("input").attr('value',"").end();
        row.show();
        
        var lastrow=$("table tr:last").find(".Ads_RouteId").val();
        console.log(lastrow);
        
        var col = '<td><button class="btn btn-danger btn-xs" id="btn_remove" name="yt0" type="button">Remove</button></td>';  
        row.append(col); 
        row.appendTo("table");
        
        
        count--;
        
      
        if(count<=1){
        $("#btn_add").attr('disabled','disabled');
    } 
    
 
    //$("#Ads_RouteId option[value="+1+"]").not($("#Ads_RouteId:first")).remove();
   // t = $("table tr:last").find("#Ads_RouteId");
  
    
    });
       
        $(document).on('change',"#Ads_RouteId",function(){
        $(this).closest("tr").find("input").attr('disabled','disabled');
    
        $.ajax({url:"<?php echo Yii::app()->urlManager->createUrl("/Ads/AjaxAvailable")?>",
        data: "routeId="+$(this).val()+"&clientId="+clientId,
        context: this,
        success:function(result){
            
            $(this).closest("tr").find('td:eq(2)').html('Max Allowed: '+result);
            $(this).closest("tr").find("input").replaceWith('<input type="number" name="Ads[NumScreens][]" id="Ads_NumScreens" min="1" max='+result+' required>');
    
  }});
});
    
    });
</script>