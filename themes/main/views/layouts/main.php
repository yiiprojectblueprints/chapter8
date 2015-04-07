<!DOCTYPE html>
<html>
	<head>
        <title><?php echo CHtml::encode(Yii::app()->name); ?></title>

        <?php Yii::app()->clientScript
        				->registerMetaTag('text/html; charset=UTF-8', 'Content-Type')
        				->registerCssFile('//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css')
        				->registerCssFile('//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css')
        				->registerCssFile('//fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700')
        				->registerCssFile(Yii::app()->baseUrl . '/css/main.css')
        				->registerScriptFile('//code.jquery.com/jquery.js')
        				->registerScriptFile('//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js')
                        ->registerScriptFile('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.6.0/moment.min.js')
                        ->registerScriptFile('//cdnjs.cloudflare.com/ajax/libs/livestamp/1.1.2/livestamp.min.js');
        ?>
	</head>
	<body>
		<div class="row">
			<div class="container">
				<nav class="navbar navbar-default navbar-fixed-top blog-masthead" role="navigation">
					<div class="container">
						<div class="navbar-header">
							<a class="navbar-brand" href="/"><?php echo CHtml::encode(Yii::app()->name); ?></a>

						</div>
						<div class="navbar-collapse collapse">
							<ul class="nav navbar-nav navbar-right">
								<?php if (Yii::app()->user->isGuest): ?>
									<li><?php echo CHtml::link('Login', $this->createUrl('site/login')); ?></li>
									<li><?php echo CHtml::link('Register', $this->createUrl('user/register')); ?></li>
								<?php else: ?>
									<li><?php echo CHtml::link('My Profile', $this->createUrl('user/index')); ?></li>
									<li><?php echo CHtml::link('Logout', $this->createUrl('site/logout')); ?></li>
								<?php endif; ?>
							</ul>
						</div>
					</div>
				</nav>
			</div>
		</div>
		<div class="container">
			<div class="row" style="margin-top: 100px;">
	        	<div class="col-sm-12 main">
                    <?php
                        foreach(Yii::app()->user->getFlashes() as $key => $message)
                            echo '<div class="alert alert-' . $key . '">' . $message . "</div>";
                    ?>
                    <div class="blog-header">
						<h1 class="blog-title">YiiCMS</h1>
						<p class="lead blog-description">A CMS written in Yii Framework</p>
					</div>
					<?php echo $content; ?>
				</div>
			</div>
		</div>
	</body>
</html>
