<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo CHtml::encode(Yii::app()->name); ?> Dashboard</title>

    <?php Yii::app()->clientScript
            ->registerMetaTag('text/html; charset=UTF-8', 'Content-Type')
            ->registerCssFile('//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css')
            ->registerCssFile('//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css')
            ->registerCssFile('//fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700')
            ->registerCssFile(Yii::app()->baseUrl . '/css/main.css')
            ->registerCssFile($this->getAsset().'/dashboard.css')
            ->registerScriptFile('//code.jquery.com/jquery.js')
            ->registerScriptFile('//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js')
            ->registerScriptFile('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.6.0/moment.min.js')
            ->registerScriptFile('//cdnjs.cloudflare.com/ajax/libs/livestamp/1.1.2/livestamp.min.js');
    ?>
  </head>
  <body>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid" style="margin-right: 15px;">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <?php echo CHtml::link(CHtml::encode(Yii::app()->name).' Dashboard', $this->createUrl('/dashboard'), array('class' => 'navbar-brand')); ?>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><?php echo CHtml::link('Logout', $this->createUrl('/site/logout')); ?></li
          </ul>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li><?php echo CHtml::link('Categories', $this->createUrl('/dashboard/category')); ?></li>
            <li><?php echo CHtml::link('Content', $this->createUrl('/dashboard')); ?></li>
            <li><?php echo CHtml::link('Users', $this->createUrl('/dashboard/user')); ?></li>
            <li><?php echo CHtml::link('Files', $this->createUrl('/dashboard/file')); ?></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <?php
                foreach(Yii::app()->user->getFlashes() as $key => $message)
                    echo '<div class="alert alert-' . $key . '">' . $message . "</div>";
            ?>
          <?php echo $content; ?>
        </div>
      </div>
    </div>
  </body>
</html>
