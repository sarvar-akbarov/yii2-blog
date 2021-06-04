<?php

use app\models\BannerItem;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BannerItem */
?>
<div class="banner-item-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            
            [
                'attribute'=>'title',
                'value' => function($model){
                    return array_values($model->translatableAttr['title'])[0];
                }
            ],
            [
                'attribute'=>'target_blank',
                'value' => function($model){
                    return BannerItem::getTarget()[$model->target_blank];
                }
            ],
            [
                'attribute'=>'status',
                'value' => function($model){
                    return getStatus()[$model->status];
                }
            ],
            'url:url',
            
            [
                'attribute'=>'type',
                'value' => function($model){
                    return BannerItem::getTypeList()[$model->type];
                }
            ],
            [
                'attribute'=>'code',
                'format' => 'ntext',
                'visible' => !$model->getImage(),
            ],
            [
                'attribute'=>'img',
                'format' => 'raw',
                'visible' => $model->getImage(),
                'value' => function($model){
                    return $model->getImage() ? $model->getImage() : '';
                }
            ],
            'show_start:date',
            'show_finish:date',
            'show_limit',
            'sorting_number',
            'time',
        ],
    ]) ?>

</div>
