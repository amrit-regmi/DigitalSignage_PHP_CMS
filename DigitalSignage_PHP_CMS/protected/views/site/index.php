<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
?>


<h1>Login</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'Loginform',
        'type'=>'horizontal',
	'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    'clientOptions' => array(
        'validateOnSubmit'=>true,
        'validateOnChange'=>false,
        'validateOnType'=>false,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
        <?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup($model,'username',array('wrapperHtmlOptions' => array('class' => 'col-sm-3',),)); ?>

	<?php echo $form->passwordFieldGroup($model,'password',array('wrapperHtmlOptions' => array('class' => 'col-sm-3',),)); ?>
        
	<?php echo $form->checkBoxGroup($model,'rememberMe'); ?>
        <a rel="tooltip" title="Click here to get a new password reset link" href="<?php echo Yii::app()->urlManager->createUrl('/site/forgotPassword'); ?>">Forgot my password</a>
 | <a rel="tooltip" title="Click here to get a new activation code for your account" href="<?php echo Yii::app()->urlManager->createUrl('/site/resend'); ?>">Haven't got my activation code yet.</a>
        
	<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'context'=>'primary',
            'label'=>'Login',
        )); ?>
            
	</div>
<?php $this->endWidget(); ?>
</div>
<!-- form -->
<a href="http://www.beyondsecurity.com/vulnerability-scanner-verification/sastotest.info"><img src="https://secure.beyondsecurity.com/verification-images/sastotest.info/vulnerability-scanner-2.gif" alt="Website Security Test" border="0" /></a>
