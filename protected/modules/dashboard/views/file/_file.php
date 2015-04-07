<div class="file">
	<a href="<?php echo $data->value; ?>"><img src="<?php echo $data->value; ?>" style="width: 150px; height: 150px;"/></a>
	<?php echo CHtml::link('Article ID: '. $data->content_id, $this->createUrl('/dashboard/default/save', array('id' => $data->content_id))); ?>
	<?php echo CHtml::link('Delete', $this->createUrl('/dashboard/file/delete', array('id' => $data->id)), array('class' => 'btn btn-danger')); ?>
</div>