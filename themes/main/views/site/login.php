<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'htmlOptions' => array(
			'class' => 'form-signin',
			'role' => 'form'
	),
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<?php if (!Yii::app()->user->isGuest): ?>
		<h2 class="form-signin-heading">You are already signed in! Please <?php echo CHtml::link('logout', $this->createUrl('/site/logout')); ?> first.</h2>
	<?php else: ?>
	 	<h2 class="form-signin-heading">Please sign in</h2>
	 	<?php echo $form->errorSummary($model); ?>
		<?php echo $form->textField($model,'username', array('class' => 'form-control', 'placeholder' => 'Username')); ?>
		<?php echo $form->passwordField($model,'password', array('class' => 'form-control', 'placeholder' => 'Password')); ?>

		<?php echo CHtml::tag('button', array('class' => 'btn btn-lg btn-primary btn-block'), 'Submit'); ?>

		<p><?php echo CHtml::link('or login with Twitter', $this->createUrl('hybrid/twitter')); ?></p>

	<?php endif; ?>

<?php $this->endWidget(); ?>
