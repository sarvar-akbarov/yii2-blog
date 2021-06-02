<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BlogCategory */
?>
<div class="blog-category-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=>'icon_s',
                'format' => 'html',
                'value' => function($model){
                    return $model->getLogo();
                }
            ],
            [
                'attribute'=>'icon_b',
                'format' => 'html',
                'value' => function($model){
                    return $model->getLogo(false);
                }
            ],
            'keyword:ntext',
            [
                'attribute'=>'status',
                'value' => function($model){
                    return getStatus()[$model->status];
                }
            ],
        ],
    ]) ?>

</div>
