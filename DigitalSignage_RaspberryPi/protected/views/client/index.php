<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of index
 *
 * @author amrit regmi
 */
$this->breadcrumbs=array(
	'Clients'=>array('/Clients'),

);
$this->widget('booster.widgets.TbButton',
	array('label'=>'Add New Client','context'=>'primary','buttonType'=>'link','url'=>yii::app()->createUrl('/Client/Add')));

$this->widget('booster.widgets.TbGridView',array(
    'dataProvider'=>$data,
    'type'=>'striped bordered condensed',
    'template'=>"{items}\n{pager}",
    'columns'=>array(
        array(
            'value'=>'CHtml::link($data->Name,Yii::app()->urlManager->createUrl("/client/".$data->ClientId),array(\'style\'=>\'display:block;width:100%\'))', 
            'header'=>"Name",
            'name'=>"Name",
            'type'=>'raw',
        ),
        array(
            'header'=>"Address",
            'name'=>"Address",
            'type'=>'raw',
        ),
        array(
            'header'=>"Contact",
            'name'=>"Contact",
            'type'=>'raw',
        ),
         array(
            'class'=>'booster.widgets.TbButtonColumn',
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
                                    //'url'=>'Yii::app()->controller->createUrl("/project/delete/"..$data->RouteId)',
                                    'visible'=>'true',
                                )
                        ),
                        

        ),
    )));
    

