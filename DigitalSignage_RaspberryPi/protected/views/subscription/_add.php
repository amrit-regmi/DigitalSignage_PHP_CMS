<div style="margin-bottom: 60px;">
   
<?php

$form = $this->beginWidget(
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
echo '<a href="#" class="close" style="color:red" data-dismiss="alert">×</a>';
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


<?php $this->endWidget();

?></div>