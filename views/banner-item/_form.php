<?php

use app\models\BannerItem;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\BannerItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banner-item-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-10">
            <?=$this->render('_translatable_attributes', [
                'form' => $form,
                'languages' => $languages,
                'model' => $model
            ])?>
        </div>
        <div class="col-md-10">
            <?= $form->field($model, 'type')->dropDownList(BannerItem::getTypeList()) ?>

            <div class="row" id="type-image">
                <div class="col-md-6 col-xs-6">
                    <div id="polls">
                        <?= $model->img != null ? Html::img('/'.$model->img, [
                            'style' => 'width:180px;',
                        ]): '' ?>
                    </div>
                    <br>
                    <label for="banneritem-file" style="cursor:pointer;">
                        <i class="fa fa-pencil btn btn-default" ></i> <?=$model->getAttributeLabel('img')?>
                    </label>
                    <?= $form->field($model, 'file', ['inputOptions' =>['value' => $model->file]])->fileInput(['accept' => 'image/*', 'class' => "poster_image", 'style' => 'display:none;'])->label(false); ?>
                </div>
            </div>
            <div id="type-code" style="display: none;">
                <?= $form->field($model, 'code')->textarea(['rows' => 6]) ?>
            </div>
            <hr>                
            <div class="row">
                <div class="col-md-5">
                    <?= $form->field($model, 'show_start')->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => Yii::t('app','Select')],
                        'pluginOptions' => [
                            'autoclose'=>true
                        ]
                    ]);?>
                </div>
                <div class="col-md-5">
                    <?= $form->field($model, 'show_finish')->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => Yii::t('app','Select')],
                        'pluginOptions' => [
                            'autoclose'=>true
                        ]
                    ]);?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'time')->textInput(['type' => 'number']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'show_limit')->textInput(['type' => 'number']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'sorting_number')->textInput(['type' => 'number']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'status')->dropDownList(getStatus()) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'target_blank')->dropDownList(BannerItem::getTarget()) ?>
                </div>
            </div>
        </div>
    </div>
    


    <hr>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
</div>
<?php
$typeImg = BannerItem::TYPE_IMAGE;
$this->registerJs(<<<JS

    var fileCollection = new Array();
    $(document).on('change', '.poster_image', function(e){
        var files = e.target.files;
        $.each(files, function(i, file){
            fileCollection.push(file);
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(e){
                var template = '<img style="width:180px;" src="'+e.target.result+'"> ';
                $('#polls').html('');
                $('#polls').append(template);
            };
        });
    });

    $('#banneritem-type').on('change', function(){
        if($(this).val() == '$typeImg'){
            $('#type-image').show();
            $('#type-code').hide();
        }else{
            $('#type-image').hide();
            $('#type-code').show();
        }
    })
JS
);
?>