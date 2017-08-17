<?php
/* @var $this ScreensController */
/* @var $data Screens */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ScreenId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ScreenId), array('view', 'id'=>$data->MacAdd)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('MacAdd')); ?>:</b>
	<?php echo CHtml::encode($data->MacAdd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('RouteId')); ?>:</b>
	<?php echo CHtml::encode($data->RouteId); ?>
	<br />


</div>