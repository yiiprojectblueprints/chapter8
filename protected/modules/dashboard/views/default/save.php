<h1 class="page-header"><?php echo $model->isNewRecord ? 'Create New Post' : 'Update Post'; ?></h1>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'content-form',
    'htmlOptions' => array(
        'class' => 'form-horizontal',
        'role' => 'form'
    )
)); ?>
    <?php echo $form->errorSummary($model); ?>

    <div class="form-group">
        <?php echo $form->labelEx($model,'title', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model, 'title', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('title'))); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'slug', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model, 'slug', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('slug'))); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'category_id', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->dropDownList($model,'category_id', CHtml::listData(Category::model()->findAll(), 'id', 'name')); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'body', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textArea($model, 'body', array('class' => 'form-control', 'rows' => 25, 'placeholder' => $model->getAttributeLabel('body'))); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'published', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->checkBox($model, 'published', array('class' => 'form-control')); ?>
        </div>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary pull-right col-md-offset-1')); ?>
    </div>
<?php $this->endWidget(); ?>
<?php Yii::app()->clientScript->registerCss('hide-banner', '.blog-header { display: none; }'); ?>

<?php if (!$model->isNewRecord): ?>
    <hr />
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'file-upload-form',
        'action' => $this->createUrl('/dashboard/file/upload', array('id' => $model->id)),
        'htmlOptions' => array(
            'class' => 'form-horizontal',
            'role' => 'form',
            'enctype'=>'multipart/form-data'
            
        )
    )); ?>
        <div class="form-group">
            <div class="col-sm-10">
                <input type="file" name="file" />
            </div>
        </div>

        <div class="row buttons">
            <?php echo CHtml::submitButton('Upload file', array('class' => 'btn btn-primary pull-right col-md-offset-1')); ?>
        </div>

    <?php $this->endWidget(); ?>
<?php endif; ?>
