<h1 class="page-header"><?php echo $model->isNewRecord ? 'Create New User' : 'Update User'; ?></h1>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'content-form',
    'htmlOptions' => array(
        'class' => 'form-horizontal',
        'role' => 'form'
    )
)); ?>
    <?php echo $form->errorSummary($model); ?>
    <div class="form-group">
        <?php echo $form->labelEx($model,'username', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('username'))); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'email', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('email'))); ?>
        </div>
    </div>

   <div class="form-group">
        <?php echo $form->labelEx($model,'password', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'value' => '', 'placeholder' => $model->getAttributeLabel('password'))); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'name', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model, 'name', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('name'))); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'activated', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->checkbox($model, 'activated', array('class' => 'form-control','placeholder' => $model->getAttributeLabel('activated'))); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'role_id', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->dropDownList($model,'role_id', CHtml::listData(Role::model()->findAll(), 'role_id', 'name')); ?>
        </div>
    </div>


    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary pull-right col-md-offset-1')); ?>
    </div>
<?php $this->endWidget(); ?>
