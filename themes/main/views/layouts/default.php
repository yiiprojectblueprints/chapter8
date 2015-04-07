<?php $this->beginContent('//layouts/main'); ?>
	<div class="row">
	  	<div class="col-sm-8 blog-main"><?php echo $content; ?></div>
	  	<div class="col-sm-3 col-sm-offset-1 blog-sidebar">
	  		<div class="sidebar-module sidebar-module-inset">
	            <h4>About</h4>
	            <p>This is my blog where I write about things I find interesting</p>
	        </div>
	        <div class="sidebar-module">
	        	<form action="/content/search" method="GET">
	        		<input type="text" name="q" placeholder="Search..." value="<?php echo Yii::app()->request->getParam('q'); ?>" />
	        	</form>
	        </div>
	        <div class="sidebar-module">
	            <h4>Recent Posts</h4>
	            <?php $recent = Content::model()->findAllByAttributes(array('published' => 1), array('order' => 'created DESC', 'limit' => 5)); ?>
	            <ol class="list-unstyled">
	            	<?php foreach ($recent as $post): ?>
	            		<li>
	            			<?php echo CHtml::link($post->title, $this->createUrl('/'.$post->slug)); ?>
	            		</li>
	            	<?php endforeach; ?>
	            </ol>
	        </div>
		</div>
	</div>
	
<?php $this->endContent(); ?>