<div class="homepage-container">
	<div class="white-box">
		<h3>Change Your Information</h3>
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'					=>	'login-form',
			'enableAjaxValidation'	=>	true,
			'action'                => $this->createUrl('user/index')
		)); ?>
			<?php echo $form->errorSummary($profileform, NULL, NULL, array('class' => 'bg-danger')); ?>
			<div class="form-group">
                <p>Please enter your <strong>current</strong> password to make any changes to your account</p>
				<?php echo $form->passwordField($profileform,'password', array('class' => 'form-control', 'placeholder' => 'Your CURRENT password', 'value' => '')); ?>
			</div>

            <h4>Change Your Email Address</h4>
			<div class="form-group">
				<?php echo $form->textField($profileform,'email', array('class' => 'form-control', 'placeholder' => 'Your Email address', 'value' => $user->email)); ?>
                <?php if ($user->new_email !== NULL): ?>
                    <p>Your new email <strong><?php echo $user->new_email; ?></strong> is awaiting verification.</p>
                <?php endif; ?>
			</div>

            <h4>Change Your Personal Information</h4>
			<div class="form-group">
				<?php echo $form->textField($profileform,'name', array('class' => 'form-control', 'placeholder' => 'Your Full Name', 'value' => $user->name)); ?>
			</div>

            <h4>Change Your Password</h4>
            <p>To change your password, enter your new password here</p>
            <div class="form-group">
				<?php echo $form->passwordField($profileform,'newpassword', array('class' => 'form-control', 'placeholder' => 'Your New Password', 'value' => '')); ?>
			</div>

            <div class="form-group">
                <p>Please verify your new password</p>
				<?php echo $form->passwordField($profileform,'newpassword_repeat', array('class' => 'form-control', 'placeholder' => 'Your New Password (again)', 'value' => '')); ?>
			</div>

			<?php echo CHtml::tag('button', array('class' => 'btn btn-primary btn-block'), 'Change My Information'); ?>
		<?php $this->endWidget(); ?>
	</div>
</div>
