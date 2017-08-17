<?php
/* @var $this AdsController */
if(isset($_GET['ref'])){
    $ref =$_GET['ref'];
}else $ref=null;
$this->breadcrumbs=array(
        'Ads'=>array('/ads'),
	'View',
);
?>
<?php if(Yii::app()->user->hasFlash('success')):?>
<div class='alert in alert-block fade alert-success'><a href='#' class='close' data-dismiss='alert'>×</a><?php echo Yii::app()->user->getFlash('success'); ?></div>
<?php endif; ?>

<div class="pull-left">
    <img class="ImagePreviewLoader img-polaroid img-responsive img-rounded "src="<?php echo Yii::app()->getBaseUrl().$model->Source ?>">
</div>
<div class="pull-left" style="margin-left: 10px;">
<?php $this->beginWidget(
    'booster.widgets.TbPanel',
    array(
        'title' => '  Advert Detail',
        'headerIcon' => 'picture',
    )
); ?>
<table >
    <tr><td>Client Name</td><td><?php echo Client::model()->findByPk($model->ClientId)->Name?></td></tr>
        <tr><td>Name</td><td><?php $this->widget('booster.widgets.TbEditableField', array(
    'type' => 'text',
    'model' => $model,
    'attribute' => 'name',
    'url' => yii::app()->createUrl('/Ads/updateAssignments/'.$model->AdsId), //url for submit data
));?></td></tr>
        <tr><td>Number of Routes</td><td><?php echo sizeOf(Ads::getRoutes($model->AdsId,false)).' &nbsp&nbsp   '; $this->widget(
    'booster.widgets.TbButton',
    array(
        'label' => 'Update',
        'size' => 'extra_small',
        'context' => 'warning',
        'buttonType'=>'ajaxLink',
                'url'=>yii::app()->createUrl('/Ads/updateAssignments/'.$model->AdsId."/?ref=".$ref),
                 'ajaxOptions'=>array('update' => '#tcontent'), 
                  'htmlOptions'=>array('id' => 'mainCatAjaxLink', 'onclick' => '$("#popbox").css("visibility", "visible")')
    )
);?></td></tr>
        <tr><td>Number of Screens</td><td><?php echo $model->occurence?></td></tr>
        <tr><td>Uploaded on</td><td><?php echo $model->Date;?></td></tr>
        <tr><td>Expires On</td><td><?php //echo $model->Date;
      $this->widget(
    'booster.widgets.TbEditableField',
    array(
        'type' => 'date',
        'model' => $model,
        'attribute' => 'Expires',
        'url' => yii::app()->createUrl('/Ads/updateAssignments/'.$model->AdsId),
        'placement' => 'right',
        'format' => 'yyyy-mm-dd',
        'viewformat' => 'yyyy-mm-dd',
        'options' => array(
            'datepicker' => array(
                'language' => 'en'
            )
        ),
    )
);?></td></tr>
        

</table>
<?php $this->endWidget(); 
$this->widget(
    'booster.widgets.TbButton',
    array(
        'buttonType'=>'link',
         'url'=>yii::app()->createUrl('/Ads/Remove/'.$model->AdsId."/?ref=".$ref),
        'label' => 'Remove this Advert',
        'size' => 'default',
        'context' => 'primary',
    )
);?>
    
    <div id="popbox" style="width: auto;
            margin: auto;
            top: 175px;
            color: rgb(255, 255, 255);
            visibility: visible;
            position: fixed;
            background: #5bc0de;
            padding: 50px;
            border-radius: 15px;
            visibility:hidden">
     <h1>Redistribute Ads to route</h1>
        <div id="tcontent"></div>
    </div>
</div>

<p>
	
</p>
