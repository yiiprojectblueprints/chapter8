<h3>Manage Posts</h3>
<?php echo CHtml::link('Create New Post', $this->createUrl('content/save'), array('class' => 'btn btn-primary')); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$model->search(),
    'columns' => array(
    	'id',
    	'title',
    	'published' => array(
    		'name' => 'Published',
    		'value' => '$data->published==1?"Yes":"No"'
    	),
    	'author.username',
    	array( 
            'class'=>'CButtonColumn',
            'viewButtonUrl'=>'Yii::app()->createUrl("/".$data["slug"])',
      		'deleteButtonUrl'=>'Yii::app()->createUrl("/content/delete", array("id" =>  $data["id"]))',
      		'updateButtonUrl'=>'Yii::app()->createUrl("/content/save", array("id" =>  $data["id"]))',
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