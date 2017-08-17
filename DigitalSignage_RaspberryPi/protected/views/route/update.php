<?php
/* @var $this RouteController */

$this->breadcrumbs=array(
	$model->RouteName=>array('/route/'.$model->RouteId),
	'Update',
);

echo $this->renderPartial('_form',array('model'=>$model)); ?>