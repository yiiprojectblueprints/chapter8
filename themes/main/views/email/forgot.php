<?php $activationLink = $this->createAbsoluteUrl('user/resetpassword', array('id' => $user->activation_key)); ?>

<div>
	<h1>Hi <?php echo $user->name; ?></h1><br />
	<p>We recently recieved a request to reset your <?php echo CHtml::link('YiiCMS', $this->createAbsoluteUrl('site/index')); ?> password.</p>
	<p>To fulfill this request, please click on the link below. If you did not initate this request you may safely ignore this email</p>

	<p><?php echo CHtml::link($activationLink, $activationLink); ?></p>
	<br />
	<p>Thank you!</p>
</div>
