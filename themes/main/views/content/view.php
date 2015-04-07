<div class="blog-post">
	<h2 class="blog-post-title"><?php echo CHtml::encode($post->title); ?></h2>
	<p class="blog-post-meta"><?php echo date('M d, Y', $post->created); ?> by <a href="#"><?php echo CHtml::encode($post->author->name); ?></a> in <?php echo CHtml::link(CHtml::encode($post->category->name), $this->createUrl('/'.$post->category->slug)); ?>
	<?php $md = new CMarkdownParser; ?>
	<?php echo $md->safeTransform($post->body); ?>
	<hr />
	<?php $this->widget('DisqusWidget', array(
		'shortname'  => Yii::app()->params['includes']['disqus']['shortname'],
		'url' 		 => $this->createAbsoluteUrl('/'.$post->slug),
		'title' 	 => $post->title,
		'identifier' => $post->id
	)); ?>
</div>