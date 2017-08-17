<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Manage Credential',
);

$form = $this->beginWidget(
	'booster.widgets.TbActiveForm',
	array(
		'id' => 'Users_manage',
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
			$model,'username',
                        array(  
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
                                    
				),
                            'widgetOptions' => array('htmlOptions' => array(),)
				
			)
		);
echo $form->passwordFieldGroup(
			$model,'password',
                        array(  
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
                                    
				),
                            'widgetOptions' => array('htmlOptions' => array(),)
				
			)
		);
echo $form->passwordFieldGroup(
			$model,'repeatPassword',
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
        'buttonType' =>'submit','label' => 'Save','context'=>'primary',
        'htmlOptions' => array(
					'class' => 'col-sm-3',
                                    
				),
      
        
        )
    );
    
?>
</div>

<?php $this->endWidget();

?>