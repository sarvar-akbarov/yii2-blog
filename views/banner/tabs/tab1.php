<?php
$this->title = Yii::t('app','Main Info')
?>

<?= \yii\widgets\DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'attribute'=>'keyword',
        ],
        [
            'attribute'=>'title',
        ],
        [
            'attribute'=>'status',
            'value' => function($model){
                return getStatus()[$model->status];
            }
        ],    
    ],
]) ?>

<hr>

<?=$this->render('../../banner-item/index', [
    'banner_id' => $model->id,
    'dataProvider' => $dataProvider,
    'searchModel' => $searchModel,
]);?>