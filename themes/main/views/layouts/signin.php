<!DOCTYPE html>
<html>
	<head>
        <title><?php echo CHtml::encode(Yii::app()->name); ?> | Signin</title>

        <?php Yii::app()->clientScript
        				->registerMetaTag('text/html; charset=UTF-8', 'Content-Type')
        				->registerCssFile('//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css')
        				->registerCssFile(Yii::app()->baseUrl . '/css/signin.css')
        				->registerScriptFile('//code.jquery.com/jquery.js', CClientScript::POS_END)
        				->registerScriptFile('//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js'); ?>
	</head>
	<body>
		<div class="row">
			<div class="container">
				<?php echo $content; ?>				
			</div>
		</div>
	</body>
</html>