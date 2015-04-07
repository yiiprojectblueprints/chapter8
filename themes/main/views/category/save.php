</h3><?php echo $model->isNewRecord ? 'Create New Category' : 'Update Category'; ?></h3>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'content-form',
    'htmlOptions' => array(
        'class' => 'form-horizontal',
        'role' => 'form'
    )
)); ?>
    <?php echo $form->errorSummary($model); ?>

    <div class="form-group">
        <?php echo $form->labelEx($model,'name', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model, 'name', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('name'))); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'slug', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model, 'slug', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('slug'))); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'description', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textArea($model, 'description', array('class' => 'form-control', 'rows' => 10, 'placeholder' => $model->getAttributeLabel('description'))); ?>
        </div>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary pull-right col-md-offset-1')); ?>
    </div>
<?php $this->endWidget(); ?>
<?php Yii::app()->clientScript->registerCss('hide-banner', '.blog-header { display: none; }');
