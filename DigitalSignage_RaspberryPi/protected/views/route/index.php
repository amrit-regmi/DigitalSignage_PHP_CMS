<?php
/* @var $this RouteController */

$this->breadcrumbs=array(
	'Route'=>array('/route'),

);
$this->widget('booster.widgets.TbButton',
	array(
            'buttonType'=>'link','label'=>'Add new Route','context'=>'primary','url'=>yii::app()->createUrl('/Route/Add')));
	//array('label'=>'Manage Screens', 'url'=>'admin'),);



?>


<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped bordered condensed',
    'dataProvider'=>$data,
    'template'=>"{items}\n{pager}",
    'columns'=>array(
        array(
            'value'=>'CHtml::link($data->RouteName,Yii::app()->urlManager->createUrl("/route/".$data->RouteId),array(\'style\'=>\'display:block;width:100%\'))', 
            'header'=>"Route Name",
            'name'=>"RouteName",
            'type'=>'raw',
        ),
	array(
          'name'=>'NumScreens',
          'header'=>'Numscreens',
        ),
        array(
          'name'=>'ActiveScreens',
          'header'=>'Active Screens',
        ),
        array(
          'name'=>'Description',
          'header'=>'Description',
        ),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'visible'=> true,
            'htmlOptions'=>array('style'=>'width: 50px'),
            'template'=>'{update}{delete}',
            //'afterDelete'=>'function(link,success,data){if(success){$("#page").prepend(data);}}',
            'buttons'=>array(
                                'update' => array(
                                  //'url'=>'Yii::app()->controller->createUrl("/route/update/".$data->RouteId)',
                                  'visible'=>'true',
                                ),
                               'delete' => array(
                                    //'url'=>'Yii::app()->controller->createUrl("/route/delete/"..$data->RouteId)',
                                    'visible'=>'true',
                                )
                        ),
                        

        ),
    ),
)); ?>
