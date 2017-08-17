<?php
/* @var $this UsersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Users',
);
$this->widget('booster.widgets.TbButton',
	array( 'buttonType'=>'link','label'=>'Add New User','context'=>'primary','url'=>yii::app()->createUrl('/Users/Add')));
	//array('label'=>'Manage Screens', 'url'=>'admin'),); ?>

<?php $this->widget('booster.widgets.TbGridView', array(
    'type'=>'striped bordered condensed',
    'dataProvider'=>$dataProvider,
    'template'=>"{items}",
    'columns'=>array(
        array('name'=>'firstname', 'header'=>'First Name',),
        array('name'=>'lastname', 'header'=>'Last Name',),
        array('name'=>'username', 'header'=>'Username',),
        array('name'=>'email', 'header'=>'Email',),
        array('name'=>'phone', 'header'=>'Phone',),
        array('name'=>'dateOfLastAccess', 'header'=>'Date of Last Access',),
        array('name'=>'accesslevel', 'header'=>'Acess level',
            'value'=>'($data->accesslevel == 1)?("SuperAdmin"):(($data->accesslevel == 2)?("admin"):("client"))')
        ,
         array(
            'class'=>'booster.widgets.TbButtonColumn',
            'visible'=> true,
            'htmlOptions'=>array('style'=>'width: 50px'),
            'template'=>'{update}{delete}',
            //'afterDelete'=>'function(link,success,data){if(success){$("#page").prepend(data);}}',
            'buttons'=>array(
                                'update' => array(
                                  //'url'=>'Yii::app()->controller->createUrl("/route/update/".$data->RouteId)',
                                  'visible'=>'($data->accesslevel == 1)?(false):(true)',
                                ),
                               'delete' => array(
                                    //'url'=>'Yii::app()->controller->createUrl("/project/delete/"..$data->RouteId)',
                                    'visible'=>'($data->accesslevel == 1)?(false):(true)',
                                )
                        ),
                        

        ),)
    
    )
        );