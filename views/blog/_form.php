<?php
use app\models\Blog;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Blog */
/* @var $form yii\widgets\ActiveForm */
$model->image != null ? $path = '/'.$model->image : $path = '';
$readOnly = isset($readOnly) ? 1 : 0;
?>

<div class="blog-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'validateOnSubmit' => false,
        'validateOnChange' => false,
        'validateOnBlur' => false,
        'enableAjaxValidation' => false
    ]); ?>

    <div class="row">
        <div class="col-md-10" style="">
            <div id="polls">
                <?= Html::img($path, [
                    'style' => 'width:300px;',
                ]) ?>
            </div>
            <br>
            <label for="blog-file" style="cursor:pointer;">
                <?= !$readOnly ? '<i class="fa fa-pencil btn btn-default" ></i>' : ''; ?> <?=$model->getAttributeLabel('image')?>
                <?= $form->field($model, 'image')->hiddenInput([])->label(false) ?>
            </label>
            <?= $form->field($model, 'file', ['inputOptions' =>['value' => $model->file]])->fileInput(['accept' => 'image/*', 'class' => "poster_image", 'style' => 'display:none;'])->label(false); ?>
        </div>
        <div class="col-md-10">
            <?= $form->field($model, 'status')->dropDownList(getStatus()) ?>

            <?=$form->field($model, 'category_id')->widget(Select2::classname(), [
                'data' => Blog::getCategoryList(),
                'options' => ['placeholder' => 'Select a state ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);?>

        </div>
        <div class="col-md-10">
            <h2>Tarjima li maydonlar</h2>
        </div>
        <div class="col-md-10">
            <?=$this->render('_translatable_attributes', [
                'form' => $form,
                'languages' => $languages,
                'model' => $model
            ])?>
        </div>
        <div class="col-md-10">
                
            <?php
                $button = '<button type="button" class="btn btn-xs btn-link" style="padding-left:0px;padding-top:0px;margin-top:-5px;" onclick="
                    val = $(\'#attr-title-1\').val();
                    $(\'#blog-slug\').val(generateSlug(val))">
                    сгенерировать
                </button>';
                $template = '<div class="row">
                    <div class="col-md-1">{label}</div>
                    <div class="col-md-11">
                    <div class="input-group">{input}<span class="input-group-addon">' . $button . '</span></div>{hint}{error}
                </div>
                </div>';
            ?>
            <?= $form->field($model, 'slug', ['template' => $template])->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-10 form-group">
            <hr>
            <?php if($readOnly): ?>
                <?= Html::a(Yii::t('app','Edit'), ['update','id' => $model->id], ['class' => 'btn btn-info'])?>
            <?php else: ?>
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
            <?php endif ?>
            <button type="button" class="btn btn-default pull-left" onclick="window.location.href='index'" > <?= Yii::t('app','Cancel') ?></button>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
    
</div>
<?php

$this->registerJsFile('/js/slug.js');
$this->registerJs(<<<JS

    if($readOnly == '1'){
        $('input[type="text"],input[type="file"],select, textarea').attr('disabled','true');
    }

    var fileCollection = new Array();
    $(document).on('change', '.poster_image', function(e){
        var files = e.target.files;
        $.each(files, function(i, file){
            fileCollection.push(file);
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(e){
                var template = '<img style="width:300px;" src="'+e.target.result+'"> ';
                $('#blog-image').val('ok');
                $('#polls').html('');
                $('#polls').append(template);
            };
        });
    });

   
JS
);
?>