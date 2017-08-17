<?php
/* @var $this ScreensController */
/* @var $model Screens */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ScreenId'); ?>
		<?php echo $form->textField($model,'ScreenId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'MacAdd'); ?>
		<?php echo $form->textField($model,'MacAdd',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'RouteId'); ?>
		<?php echo $form->textField($model,'RouteId'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->