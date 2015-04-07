<div>
	<h1>Hi <?php echo $user->name; ?></h1><br />
	<p>This is a notification that your <?php echo CHtml::link('YiiCMS', $this->createAbsoluteUrl('site/index')); ?> password has recently been changed.</p>
	<p>If you did not request this change, please use <?php echo CHtml::link('forgot password', $this->createAbsoluteUrl('user/verify')); ?> tool to change your password immediately, as it is likely someone has gained access to your account without your knowledge.</p>
	<p>Thank you!</p>
</div>
