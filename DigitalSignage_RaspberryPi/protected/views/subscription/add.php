<?php
/* @var $this SubscriptionController */

$this->breadcrumbs=array(
	'Subscription'=>array('/subscription'),
	'Add',
);
?>

<?php echo $this->renderPartial('_form',array('model'=>$model,'routelist'=>$routelist,'id'=>$id)); ?>