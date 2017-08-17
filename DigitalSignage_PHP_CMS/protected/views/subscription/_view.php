<?php
/* @var $this SubscriptionController */
/* @var $data Subscription */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('SubscriptionId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->SubscriptionId), array('view', 'id'=>$data->SubscriptionId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('RouteId')); ?>:</b>
	<?php echo CHtml::encode($data->RouteId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NumAds')); ?>:</b>
	<?php echo CHtml::encode($data->NumAds); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NumScreen')); ?>:</b>
	<?php echo CHtml::encode($data->NumScreen); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Expire')); ?>:</b>
	<?php echo CHtml::encode($data->Expire); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ClientId')); ?>:</b>
	<?php echo CHtml::encode($data->ClientId); ?>
	<br />


</div>