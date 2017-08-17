<?php
/* @var $this SubscriptionController */
/* @var $model Subscription */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'SubscriptionId'); ?>
		<?php echo $form->textField($model,'SubscriptionId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'RouteId'); ?>
		<?php echo $form->textField($model,'RouteId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NumAds'); ?>
		<?php echo $form->textField($model,'NumAds'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NumScreen'); ?>
		<?php echo $form->textField($model,'NumScreen'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Expire'); ?>
		<?php echo $form->textField($model,'Expire'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ClientId'); ?>
		<?php echo $form->textField($model,'ClientId'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->