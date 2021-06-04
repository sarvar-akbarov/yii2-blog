<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BlogCategory */
/* @var $form yii\widgets\ActiveForm */

$model->icon_s != null ? $path1 = '/'.$model->icon_s : $path1 = '/images/logo.png';
$model->icon_b != null ? $path2 = '/'.$model->icon_b : $path2 = '/images/logo.png';
$readOnly = isset($readOnly) ? 1 : 0;
?>

<div class="blog-category-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-10" style="margin-bottom:30px;">
            <div class="row">
                <div class="col-md-6">
                    <div id="polls1">
                        <?= Html::img($path1, [
                            'style' => 'width:100px;',
                        ]) ?>
                    </div>
                    <br>
                    <label for="blogcategory-file1" style="cursor:pointer;">
                        <?= !$readOnly ? '<i class="fa fa-pencil btn btn-default" ></i>' : ''; ?> <?=$model->getAttributeLabel('icon_s')?>
                    </label>
                    <?= $form->field($model, 'file1', ['inputOptions' =>['value' => $model->file1]])->fileInput(['accept' => 'image/*', 'class' => "poster_image1", 'style' => 'display:none;'])->label(false); ?>
                </div>
                <div class="col-md-6">
                    <div id="polls2">
                        <?= Html::img($path2, [
                            'style' => 'width:100px;',
                        ]) ?>
                    </div>
                    <br>
                    <label for="blogcategory-file2" style="cursor:pointer;">
                    <?= !$readOnly ? '<i class="fa fa-pencil btn btn-default" ></i>' : ''; ?> <?=$model->getAttributeLabel('icon_b')?>
                    </label>
                    <?= $form->field($model, 'file2', ['inputOptions' =>['value' => $model->file2]])->fileInput(['accept' => 'image/*', 'class' => "poster_image2", 'style' => 'display:none;'])->label(false); ?>
                </div>
            </div>
            <?= $form->field($model, 'keyword')->textarea(['rows' => 6]) ?>
            <?= $form->field($model, 'status')->dropDownList(getStatus()) ?>
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
        <div class="col-md-10 form-group">
            <?php if($readOnly): ?>
                <?= Html::a(Yii::t('app','Edit'), ['update','id' => $model->id], ['class' => 'btn btn-info'])?>
            <?php else: ?>
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?php endif ?>
            <button type="button" class="btn btn-primary pull-right" onclick="window.location.href='index'" > <?= Yii::t('app','Cancel') ?></button>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
 
$this->registerJs(<<<JS

    if($readOnly == '1'){
        $('input[type="text"],input[type="file"],select, textarea').attr('disabled','true');
    }

    var fileCollection = new Array();
    $(document).on('change', '.poster_image1', function(e){
        var files = e.target.files;
        $.each(files, function(i, file){
            fileCollection.push(file);
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(e){
                var template = '<img style="width:180px;" src="'+e.target.result+'"> ';
                $('#polls1').html('');
                $('#polls1').append(template);
            };
        });
    });

    $(document).on('change', '.poster_image2', function(e){
        var files = e.target.files;
        $.each(files, function(i, file){
            fileCollection.push(file);
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(e){
                var template = '<img style="width:180px;" src="'+e.target.result+'"> ';
                $('#polls2').html('');
                $('#polls2').append(template);
            };
        });
    });
JS
);
?>