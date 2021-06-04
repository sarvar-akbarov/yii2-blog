<?php

use app\models\Language;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Language */
?>
<div class="language-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=>'image',
                'format' => 'html',
                'value' => function($model){
                    return $model->getImage();
                }
            ],
            'code',
            'local',
            'name',
            [
                'attribute'=>'default',
                'value' => function($model){
                    return Language::getDefault()[$model->default];
                },
        
            ],
            [
                'attribute'=>'status',
                'value' => function($model){
                    return getStatus()[$model->status];
                },
            ],
        ],
    ]) ?>

</div>
