<div class="homepage-container">
	<div class="white-box">
		<h3>Need an Account?</h3>
		<p>Signup here for a free account.</p>
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'					=>	'login-form',
			'enableAjaxValidation'	=>	true
		)); ?>
			<?php echo $form->errorSummary($user, NULL, NULL, array('class' => 'bg-danger')); ?>
			<div class="form-group">
				<?php echo $form->textField($user,'email', array('class' => 'form-control', 'placeholder' => 'Your Email address')); ?>
			</div>
            <div class="form-group">
					<?php echo $form->textField($user,'username', array('class' => 'form-control', 'placeholder' => 'Username')); ?>
				</div>
			<div class="form-group">
				<?php echo $form->passwordField($user,'password', array('class' => 'form-control', 'placeholder' => 'Password')); ?>
			</div>
			<div class="form-group">
				<?php echo $form->textField($user,'name', array('class' => 'form-control', 'placeholder' => 'Your Full Name')); ?>
			</div>
			<?php echo CHtml::tag('button', array('class' => 'btn btn-primary btn-block'), 'Register'); ?>
		<?php $this->endWidget(); ?>
	</div>
</div>
