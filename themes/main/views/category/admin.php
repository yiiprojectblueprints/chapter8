<h3>Manage Categories</h3>
<?php echo CHtml::link('Create New Category', $this->createUrl('category/save'), array('class' => 'btn btn-primary')); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$model->search(),
    'columns' => array(
    	'id',
    	'name',
    	array( 
            'class'=>'CButtonColumn',
            'viewButtonUrl'=>'Yii::app()->createUrl("/".$data["slug"])',
      		'deleteButtonUrl'=>'Yii::app()->createUrl("/category/delete", array("id" =>  $data["id"]))',
      		'updateButtonUrl'=>'Yii::app()->createUrl("/category/save", array("id" =>  $data["id"]))',
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