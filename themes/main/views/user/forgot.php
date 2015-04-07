<div class="homepage-container">
	<div class="white-box">
		<h3>Forgot Your Password?</h3>
		<p>Having difficulties remembering your password? Tell us what email you used to register your account and we'll send you a link to reset it.</p>
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'					=>	'login-form',
			'enableAjaxValidation'	=>	true,
			'action'                => $this->createUrl('user/forgot')
		)); ?>
			<?php echo $form->errorSummary($forgotform, NULL, NULL, array('class' => 'bg-danger')); ?>
			<div class="form-group">
				<?php echo $form->textField($forgotform,'email', array('class' => 'form-control', 'placeholder' => 'Your Email address')); ?>
			</div>
			<?php echo CHtml::tag('button', array('class' => 'btn btn-primary btn-block'), 'Request Password Reset Link'); ?>
		<?php $this->endWidget(); ?>
	</div>
</div>
