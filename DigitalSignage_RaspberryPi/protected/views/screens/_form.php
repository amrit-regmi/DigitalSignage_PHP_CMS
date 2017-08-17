<?php
/* @var $this ScreensController */
/* @var $model Screens */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'Screens',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'ScreenId'); ?>
		<?php echo $form->textField($model,'ScreenId'); ?>
		<?php echo $form->error($model,'ScreenId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'MacAdd'); ?>
		<?php echo $form->textField($model,'MacAdd',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'MacAdd'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'RouteId'); ?>
		<?php echo $form->textField($model,'RouteId'); ?>
		<?php echo $form->error($model,'RouteId'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->