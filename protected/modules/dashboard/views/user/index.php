<h1 class="page-header">Manage Users</h1>
<?php echo CHtml::link('Create New User', $this->createUrl('user/save'), array('class' => 'btn btn-primary')); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$model->search(),
    'htmlOptions' => array(
        'class' => 'table-responsive'
    ),
    'itemsCssClass' => 'table table-striped',
    'columns' => array(
    	'id',
    	'name',
    	array( 
            'class'=>'CButtonColumn',
            'template' => '{update}{delete}',
      		'deleteButtonUrl'=>'Yii::app()->createUrl("/dashboard/user/delete", array("id" =>  $data["id"]))',
      		'updateButtonUrl'=>'Yii::app()->createUrl("/dashboard/user/save", array("id" =>  $data["id"]))',
        ),
    ),
    'pager' => array(
    	'htmlOptions' => array(
    		'class' => 'pager'
    	),
    	'header' => '',
    	'firstPageCssClass'=>'hide',
    	'lastPageCssClass'=>'hide',
    	'maxButtonCount' => 0
    )
));
Yii::app()->clientScript->registerCss('hide-banner', '.blog-header { display: none; }');