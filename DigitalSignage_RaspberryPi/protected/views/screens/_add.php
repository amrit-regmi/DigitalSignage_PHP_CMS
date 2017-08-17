<?php

$form = $this->beginWidget(
	'booster.widgets.TbActiveForm',
	array(
		'id' => 'Screens',
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
if(($model->MacAdd != null) && $model->serialNumber != null){
    echo 'Please give this screen a name and assign it to a route';}

echo $form->textFieldGroup(
			$model,'ScreenName',
                        array(  
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
                                    
				),
                                'widgetOptions' => array('htmlOptions' => array('required'=>'required'),)
				
			)
		);
if(($model->MacAdd == null) && $model->serialNumber == null){
echo $form->textFieldGroup(
			$model,'MacAdd',
                        array(  
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
                                    
				),
                            'widgetOptions' => array('htmlOptions' => array('required'=>'required','placeholder'=>'00B0D086BBF7','pattern'=>'[0-9a-fA-F]{12}'),)
				
			)
		);
echo $form->textFieldGroup(
			$model,'serialNumber',
                        array(  
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
                                    
				),
                            'widgetOptions' => array('htmlOptions' => array('required'=>'required','placeholder'=>'0000000000000000','pattern'=>'[0-9a-fA-F]{16}'),)
				
			)
);}else{
    echo $form->hiddenField($model,'MacAdd');
    echo $form->hiddenField($model,'serialNumber');
}
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
        )

?>
<div class="form-actions  col-md-offset-3">
        <?php

    $this->widget(
    'booster.widgets.TbButton',
    array(
        'buttonType' =>'submit','label' => 'Submit','context'=>'primary',
        'htmlOptions' => array(
					'class' => 'col-sm-3',
                                    
				),
      
        
        )
    );
    
?>
</div>

<?php $this->endWidget();

?>