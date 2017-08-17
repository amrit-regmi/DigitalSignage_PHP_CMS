<?php /* @var $this Controller */
Yii::app()->clientScript->registerMetaTag('binay.devkota@gmail.com', 'developer');
Yii::app()->clientScript->registerMetaTag('info@cloudit.fi', 'publisher');
?>
<!DOCTYPE html>
<html>
<head>
    
	<meta charset='utf-8' />
	<meta name="language" content="en" />
        <meta name="google" value="notranslate" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<?php //Yii::app()->bootstrap->register(); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/select2/select2.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/select2/select2-bootstrap.css" />
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/select2/select2.min.js" ></script>
</head>

<body>

  
	<?php echo $content; ?>

	<div class="clear"></div>


</body>
</html>

