<?php
/* @var $this SubscriptionController */
/* @var $model Subscription */

$this->breadcrumbs=array(
	'Subscriptions'=>array('index'),
	$model->SubscriptionId=>array('view','id'=>$model->SubscriptionId),
	'Update',
);
echo $this->renderPartial('_form',array('model'=>$model,'routelist'=>$routelist,'id'=>$model->ClientId));