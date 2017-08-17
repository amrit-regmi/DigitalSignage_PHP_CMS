<?php
/* @var $this RouteController */

$this->breadcrumbs=array(
	'Route'=>array('/route'),
	'Add',
);

echo $this->renderPartial('_form',array('model'=>$model)); ?>