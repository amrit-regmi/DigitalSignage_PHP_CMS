<?php
/* @var $this ClientController */
/* @var $model Client */
/* @var $form CActiveForm */

$form = $this->beginWidget(
	'booster.widgets.TbActiveForm',
	array(
		'id' => 'Client',
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
			$model,'Name',
                        array(  
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
                                    
				),
                            'widgetOptions' => array('htmlOptions' => array(),)
				
			)
		);
echo $form->textFieldGroup(
			$model,'Address',
                        array(  
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
                                    
				),
                            'widgetOptions' => array('htmlOptions' => array(),)
				
			)
		);
echo $form->textFieldGroup(
			$model,'Contact',
                        array(  
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
                                    
				),
                            'widgetOptions' => array('htmlOptions' => array(),)
				
			)
		);
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