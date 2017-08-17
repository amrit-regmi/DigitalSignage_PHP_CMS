
<?php 
$client = Client::model()->findAll();
$list= CHtml::listData($client,'ClientId','Name');
$screens =  Screens::model()->getScreens($route->RouteId,false)->getData();
$screenList = CHtml::listData($screens,'ScreenId','ScreenName');

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
 
echo $form->textFieldGroup(
			$model,'name',
                        array(  
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
                                    
				),
                            'widgetOptions' => array('htmlOptions' => array('required'=>'required'),)
				
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


   echo $form->dropDownListGroup(
			$model,
			'ClientId',
			array(  'label' =>'Client',
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'data' => $list,
					'htmlOptions' => array('id'=>'Ads_ClientId','prompt'=>'-- SELECT A CLIENT --',),
				)
			)
        ) ;
    

echo $form->dropDownListGroup(
			$model,
                        'ScreenId',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
	   			'widgetOptions' => array(
	   				'data' => $screenList,
					'htmlOptions' => array('multiple' => true),
				)
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
?>


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
 $('label[for=Ads_Source]').html('Source <span class="required">*</span>');
 $('label[for=Ads_ClientId]').html('Client <span class="required">*</span>');
  });
    
    </script>