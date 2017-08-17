<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Create',
);

$form = $this->beginWidget(
	'booster.widgets.TbActiveForm',
	array(
		'id' => 'Users',
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
			$model,'firstname',
                        array(  
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
                                    
				),
                            'widgetOptions' => array('htmlOptions' => array(),)
				
			)
		);
echo $form->textFieldGroup(
			$model,'lastname',
                        array(  
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
                                    
				),
                            'widgetOptions' => array('htmlOptions' => array(),)
				
			)
		);
echo $form->textFieldGroup(
			$model,'phone',
                        array(  
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
                                    
				),
                            'widgetOptions' => array('htmlOptions' => array(),)
				
			)
		);
echo $form->textFieldGroup(
			$model,'email',
                        array(  
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
                                    
				),
                            'widgetOptions' => array('htmlOptions' => array(),)
				
			)
		);
echo $form->dropDownListGroup(
			$model,
			'accesslevel',
			array(  'label' =>'Access level',
				'wrapperHtmlOptions' => array(
                                    'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'data' => array('2'=>'admin','3'=>'client'),
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
        'buttonType' =>'submit','label' => 'Save and send activation code','context'=>'primary',
        'htmlOptions' => array(
					'class' => 'col-sm-3',
                                    
				),
      
        
        )
    );
    
?>
</div>

<?php $this->endWidget();

?>