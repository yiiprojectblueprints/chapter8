<?php $activationLink = $this->createAbsoluteUrl('user/verify', array('id' => $user->activation_key)); ?>

<div>
	<h1>Hi <?php echo $user->name; ?></h1><br />
	<p>A request has been made to change your <?php echo CHtml::link('YiiCMS', $this->createAbsoluteUrl('site/index')); ?> email address.</p>
	<p>To verify this change, please use the following link to verify your new email address.</p>

	<p><?php echo CHtml::link($activationLink, $activationLink); ?></p>
	<br />
	<p>Thank you!</p>
</div>
