<h1 class="page-header">Manage Posts</h1>

<?php echo CHtml::link('Create New Post', $this->createUrl('default/save'), array('class' => 'btn btn-primary')); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$model->search(),
    'htmlOptions' => array(
        'class' => 'table-responsive'
    ),
    'itemsCssClass' => 'table table-striped',
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
      		'deleteButtonUrl'=>'Yii::app()->createUrl("/dashboard/default/delete", array("id" =>  $data["id"]))',
      		'updateButtonUrl'=>'Yii::app()->createUrl("/dashboard/default/save", array("id" =>  $data["id"]))',
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