<?php 
 $this->breadcrumbs=array(
	'Screens'=>array('/screens'),
	$model->ScreenId=>array('/screens/'.$model->ScreenId),
        'Update'
);

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

echo $form->textFieldGroup(
			$model,'ScreenName',
                        array(  
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
                                    
				),
                                'widgetOptions' => array('htmlOptions' => array('required'=>'required'),)
				
			)
		);
echo $form->textFieldGroup(
			$model,'MacAdd',
                        array(  
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
                                    
				),
                            'widgetOptions' => array('htmlOptions' => array('required'=>'required','placeholder'=>'00B0D086BBF7'),)
				
			)
		);
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
        'buttonType' =>'submit','label' => 'Update','context'=>'primary',
        'htmlOptions' => array(
					'class' => 'col-sm-3',
                                    
				),
      
        
        )
    );
    
?>
</div>

<?php $this->endWidget();

?>