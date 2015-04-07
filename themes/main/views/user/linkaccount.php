<div class="homepage-container">
    <div class="white-box">
        <h3>Link Your Account</h3>
        <p>Enter your current password to link your profile to this social identity</p>
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'                    =>  'login-form',
            'enableAjaxValidation'  =>  true
        )); ?>
            <?php echo $form->errorSummary($model, NULL, NULL, array('class' => 'bg-danger')); ?>
            <div class="form-group">
                 <?php echo $form->passwordField($model, 'password', array('placeholder' => $model->getAttributeLabel('password') )); ?>
            </div>
            <?php echo CHtml::tag('button', array('class' => 'btn btn-primary btn-block'), 'Submit'); ?>
        <?php $this->endWidget(); ?>
    </div>
</div>
