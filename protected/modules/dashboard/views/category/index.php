<h1 class="page-header">Manage Categories</h1>
<?php echo CHtml::link('Create New Category', $this->createUrl('category/save'), array('class' => 'btn btn-primary')); ?>
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
            'viewButtonUrl'=>'Yii::app()->createUrl("/".$data["slug"])',
      		'deleteButtonUrl'=>'Yii::app()->createUrl("/dashboard/category/delete", array("id" =>  $data["id"]))',
      		'updateButtonUrl'=>'Yii::app()->createUrl("/dashboard/category/save", array("id" =>  $data["id"]))',
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