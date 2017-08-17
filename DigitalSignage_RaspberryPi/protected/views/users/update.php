<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->uid=>array('view','id'=>$model->uid),
	'Update',
);

$form = $this->beginWidget(
	'booster.widgets.TbActiveForm',
	array(
		'id' => 'Users',
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
        'buttonType' =>'submit','label' => 'Save','context'=>'primary',
        'htmlOptions' => array(
					'class' => 'col-sm-2',
                                    
				),
      
        
        )
    );
    

?>
</div>
<div class="clearfix"></div>
<div class="form-actions  col-md-offset-3" style="margin-top:10px;">
<?php $this->endWidget();
      $this->widget(
    'booster.widgets.TbButton',
    array(
        'buttonType' =>'link','label' => 'Reset Username/password', 'context'=>'success',
        'htmlOptions' => array(
					'class' => 'col-sm-3 ',
                                    
				),
         'url'=>yii::app()->createUrl('users/reset/'.$model->uid)
      
        
        )
    );
      
if(!$model->deleted){       $this->widget(
    'booster.widgets.TbButton',
    array(
        'buttonType' =>'link','label' => 'Disable','context'=>'danger',
        'htmlOptions' => array(
                'class' => 'col-sm-3 col-md-offset-1',
                                    
				),
        'url'=>yii::app()->createUrl('users/disable/'.$model->uid)
      
        
        )
);}else{
    
       $this->widget(
    'booster.widgets.TbButton',
    array(
        'buttonType' =>'link','label' => 'Enable','context'=>'Success',
        'htmlOptions' => array(
                'class' => 'col-sm-3 col-md-offset-1',
                                    
				),
        'url'=>yii::app()->createUrl('users/enable/'.$model->uid)
      
        
        )
    );
}
    

?>
</div>