<?php

use app\models\Banner;
use yii\helpers\Url;
use app\models\BannerItem;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    
    
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'img',
    //     'format' => 'html',
    //     'content' => function($model){
    //         return $model->getImage() ? $model->getImage() : '';
    //     }
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'title',
        'value' => function($model){
            return array_values($model->translatableAttr['title'])[0];
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'type',
        'value' => function($model){
            return BannerItem::getTypeList()[$model->type];
        },
        'filter' => BannerItem::getTypeList()
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'target_blank',
        'value' => function($model){
            return BannerItem::getTarget()[$model->target_blank];
        },
        'filter' => BannerItem::getTarget()
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'status',
        'value' => function($model){
            return getStatus()[$model->status];
        },
        'filter' => getStatus()
    ],
    
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'show_start',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'show_finish',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'show_limit',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'status',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'target_blank',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'sorting_number',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'time',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                $action = '/banner-item/'.$action;
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>Yii::t('app','View'),'data-toggle'=>'tooltip'],
        'updateOptions'=>['data-pjax' => 0,'title'=>Yii::t('app','Update'), 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>Yii::t('app','Delete'), 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>Yii::t('app','Are you sure?'),
                          'data-confirm-message'=>Yii::t('app','Are you sure want to delete this item')], 
    ],

];   