<div class="homepage-container">
	<div class="white-box">
		<h3>Reset Your Password</h3>
		<p>To reset your password, enter your new password in twice.</p>
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'					=>	'login-form',
			'enableAjaxValidation'	=>	true,
			'action'                => $this->createUrl('user/resetpassword/id/'.$id)
		)); ?>
			<?php echo $form->errorSummary($passwordresetform, NULL, NULL, array('class' => 'bg-danger')); ?>
			<div class="form-group">
				<?php echo $form->passwordField($passwordresetform, 'password', array('class' => 'form-control', 'placeholder' => 'Enter Your New Password')); ?>
			</div>
			<div class="form-group">
				<?php echo $form->passwordField($passwordresetform, 'password_repeat', array('class' => 'form-control', 'placeholder' => 'Enter Your New Password (again)')); ?>
			</div>
			<?php echo CHtml::tag('button', array('class' => 'btn btn-primary btn-block'), 'Reset Your Password'); ?>
		<?php $this->endWidget(); ?>
	</div>
</div>
