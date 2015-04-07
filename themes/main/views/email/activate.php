<?php $activationLink = $this->createAbsoluteUrl('user/activate', array('id' => $user->activation_key)); ?>

<div>
	<h1>Hi <?php echo $user->name; ?></h1><br />
	<p>Thanks for registering on <?php echo CHtml::link('YiiCMS', $this->createAbsoluteUrl('site/index')); ?>. Before you can access all the features of your account, you need to verify your email.</p>
	<p>Please use the following link to activate your account.</p>

	<p><?php echo CHtml::link($activationLink, $activationLink); ?></p>
	<br />
	<p>Thank you!</p>
</div>
