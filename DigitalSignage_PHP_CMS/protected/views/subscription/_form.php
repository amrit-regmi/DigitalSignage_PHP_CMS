<?php
/* @var $this SubscriptionController */
/* @var $model Subscription */
/* @var $form CActiveForm */
?>

<?php $form = $this->beginWidget(
	'booster.widgets.TbActiveForm',
	array(
		'id' => 'Subscription',
		'type' => 'horizontal',
                'enableAjaxValidation'=>true,
             'enableClientValidation'=>true,
            'clientOptions' => array(
        'validateOnSubmit'=>true,
        'validateOnChange'=>false,
        'validateOnType'=>false,

    ),
	)
);
echo $form->hiddenField($model,'ClientId',array('value'=>$id));
if($this->action->id != 'update'){
echo $form->dropDownListGroup(
			$model,
			'RouteId',
			array(  'label' =>'Route',
				'wrapperHtmlOptions' => array(
                                    'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'data' => $routelist,
					'htmlOptions' => array('required'=>'required'),
				)
			)
        );
}else{
    echo '<div class="form-group"><label class="col-sm-3 control-label" for="SubscriptionId">SubscriptionId</label><label class="col-sm-5 col-sm-9 well">'.$model->SubscriptionId.'</label></div>';
     echo '<div class="form-group"><label class="col-sm-3 control-label" for="RouteId">Route</label><label class="col-sm-5 col-sm-9 well">'.$routelist[$model->RouteId].'</label></div>';
}

echo $form->textFieldGroup(
			$model,'NumScreen',
                        array(  
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
                                    
				),
                                'widgetOptions' => array('htmlOptions' => array('required'=>'required'),)
				
			)
		);
echo $form->textFieldGroup(
			$model,'NumAds',
                        array(  
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
                                    
				),
                            'widgetOptions' => array('htmlOptions' => array('required'=>'required','placeholder'=>'00B0D086BBF7'),)
				
			)
		);
 echo $form->datePickerGroup(
			$model,
			'Expire',
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

<div class="clearfix" style="margin-bottom: 30px;"></div>

<div class="col-md-offset-3 a">
   

   <?php $this->widget(
    'booster.widgets.TbButton',
    array(
        'buttonType' =>'submit','label' => 'Submit','context'=>'primary',
        
        'htmlOptions' => array(
					'class' => 'col-lg-3',
                                    
				),
        )
    );
  
 
if($this->action->id == 'update'){
  
$this->widget('booster.widgets.TbButton',
    array(
        'buttonType' =>'link','label' => ($model->Status)?('Deactiviate subscription'):('activiate subscription'),'context'=>($model->Status)?('danger'):('success'),
        'url'=>($model->Status)?(yii::app()->createUrl('/Subscription/Deactiviate/'.$model->SubscriptionId)):(yii::app()->createUrl('/Subscription/Activiate/'.$model->SubscriptionId)),
        'htmlOptions' => array(
					'class' => 'col-lg-3',
                                    
				),
        )
    );
     
     
     
     
     
     
     
 }?>

</div>
<?php $this->endWidget(); ?>

<script>
    $(document).ready(function(){
   
        $('label[for="Subscription_RouteId"]').html('Route <span class="required">*</span>');
      
    })
</script>