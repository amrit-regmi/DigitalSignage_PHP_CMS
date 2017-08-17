<?php
$form = $this->beginWidget(
	'booster.widgets.TbActiveForm',
	array(
		'id' => 'Route',
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
			$model,'RouteName',
                        array(  
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
                                    
				),
                            'widgetOptions' => array('htmlOptions' => array('required'=>'required'),)
				
			)
		);

echo $form->textAreaGroup(
			$model,
			'Description',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'htmlOptions' => array('rows' => 5),
				)
			)
		);
?>

<div class="form-actions  col-md-offset-3">
         <?php

    $this->beginWidget(
    'booster.widgets.TbButton',
    array('buttonType' =>'submit','label' => 'Save','context'=>'primary')
    );
    $this->endWidget();
    $this->endWidget();
?>
</div>