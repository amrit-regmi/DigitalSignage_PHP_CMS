<?php /* @var $this Controller */
Yii::app()->clientScript->registerMetaTag('rit.regmi@gmail.com', 'developer');
Yii::app()->clientScript->registerMetaTag('info@sastotest.info', 'publisher');

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8' />
	<meta name="language" content="en" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<?php //Yii::app()->bootstrap->register(); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/select2/select2.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/select2/select2-bootstrap.css" />
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/select2/select2.min.js" ></script>
</head>

<body>
<?php /*$this->widget('booster.widgets.TbNavbar',array(
    
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
                array('label'=>'Routes', 'url'=>array('/Route'), 'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'Screens', 'url'=>array('/Screens'), 'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'Clients', 'url'=>array('/Client'), 'visible'=>!Yii::app()->user->isGuest)
            ),
        ),
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'htmlOptions'=>array('class'=>'pull-right'),
            'items'=>array(
                array('label'=>'Account', 'url'=>array('/user'), 'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'Help', 'url'=>array('/site/contact'), 'linkOptions' => array('rel'=>"tooltip", 'title'=>"Use this link if you need some help or to contact us")),
                array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                ),
        ),
    ),
)); 


*/
$this->widget(
    'booster.widgets.TbNavbar',
    array(
        'type' => null, // null or 'inverse'
        'brand' => 'Project name',
        'brandUrl' => yii::app()->createUrl('/'),
        'collapse' => true, // requires bootstrap-responsive.css
        'fixed' => false,
        'fluid' => false,
         'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'type'=>'navbar',
            'items'=>array(
                array('label'=>'Routes', 'url'=>array('/Route'), 'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'Screens', 'url'=>array('/Screens'), 'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'Clients', 'url'=>array('/Client'), 'visible'=>!Yii::app()->user->isGuest)
            ),
        ),
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'type'=>'navbar',
            'htmlOptions'=>array('class'=>'pull-right'),
            'items'=>array(
                array('label'=>'Users', 'url'=>array('/users'), 'visible'=>Users::isSuperAdmin()),
                 array('label'=>'Account', 'url'=>array('/users'), 'visible'=>Users::isAdmin()),
                array('label'=>'Help', 'url'=>array('/site/contact'), 'linkOptions' => array('rel'=>"tooltip", 'title'=>"Use this link if you need some help or to contact us")),
                array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                ),
        ),
    )
));
;?>

<div class="container" id="page">
        <?php
            // display all the flashes
            $allFlashes = Yii::app()->user->getFlashes(false);
            foreach($allFlashes as $kFlashes=>$mFlashes){
                $this->widget('bootstrap.widgets.TbAlert', array(
                    'fade'=>true,
                    'alerts'=>array($kFlashes),
                ));
            }
        ?>
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by <a href="http://sastobigyapan.com" target="_blank">Sasto Bigyapan</a>. <?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->
<script>
    $('[rel=select2]').select2();
    function format(state) {
        if ($(state.element).attr('data-email') == ""){ 
            return state.text; // optgroup
        }
        return state.text+"<br /><small class='muted'>"+$(state.element).attr('data-email')+"</small>";
    }
    $("[rel=select2wEmails]").select2({
        formatResult: format, 
        formatSelection: format, //appending emails to the display
        matcher: function(term, text, opt) { // for searching by emai;
                return text.toUpperCase().indexOf(term.toUpperCase())>=0
                || opt.attr("data-email").toUpperCase().indexOf(term.toUpperCase())>=0;
        },
        escapeMarkup: function(m) { return m; }
    });
</script>
</body>
</html>
