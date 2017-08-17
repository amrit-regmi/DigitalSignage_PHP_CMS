<?php /* @var $this Controller */
Yii::app()->clientScript->registerMetaTag('binay.devkota@gmail.com', 'designer');
Yii::app()->clientScript->registerMetaTag('info@cloudit.fi', 'publisher');

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	
</head>
<body>
<div class="container" id="page">
	<?php echo $content; ?>
	<div class="clear"></div>
</div><!-- page -->
</body>
</html>
