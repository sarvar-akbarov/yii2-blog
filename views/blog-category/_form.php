<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BlogCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-10">
                <?= $form->field($model, 'numlevel')->textInput() ?>
                <?= $form->field($model, 'icon_b')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'icon_s')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'keyword')->textarea(['rows' => 6]) ?>
                <?= $form->field($model, 'status')->textInput() ?>
        </div>
        <div class="col-md-10">
            <h2>Tarjima li maydonlar</h2>
        </div>
        <div class="col-md-10">
            <?=$this->render('_translatable_attributes', [
                'languages' => $languages,
                'model' => $model
            ])?>
        </div>

    </div>




  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
