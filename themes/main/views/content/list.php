<div class="blog-post">
	<h2 class="blog-post-title"><?php echo CHtml::link(CHtml::encode($data->title), $this->createAbsoluteUrl('/'.$data->slug)); ?></h2>
	<p class="blog-post-meta"><?php echo date('M d, Y', $data->created); ?> by <a href="#"><?php echo CHtml::encode($data->author->name); ?></a> in <?php echo CHtml::link(CHtml::encode($data->category->name), $this->createUrl($data->category->slug)); ?>
	<?php $md = new CMarkdownParser; ?>
	<?php echo $md->safeTransform($data->body); ?>
</div>