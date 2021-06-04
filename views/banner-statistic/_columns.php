<?php

use yii\helpers\Html;
use kartik\date\DatePicker;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'banner_id',
        'format' => 'html',
        'content' => function($model){
            return Html::a('#'.$model->banner_id, ['/banner-item/view', 'id' => $model->banner_id], ['class' => 'btn-link','role' => 'modal-remote', 'data-toggle' => 'tooltip', 'title' => Yii::t('app','Banner Item')]);
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'date',
        'format' => 'date',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'clicks',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'shows',
    ],
    // [
    //     'class' => 'kartik\grid\ActionColumn',
    //     'dropdown' => false,
    //     'vAlign'=>'middle',
    //     'urlCreator' => function($action, $model, $key, $index) { 
    //             return Url::to([$action,'id'=>$key]);
    //     },
    //     'template' => '',
    //     'viewOptions'=>['role'=>'modal-remote','title'=>Yii::t('app','View'),'data-toggle'=>'tooltip'],
    //     'updateOptions'=>['role'=>'modal-remote','title'=>Yii::t('app','Update'), 'data-toggle'=>'tooltip'],
    //     'deleteOptions'=>['role'=>'modal-remote','title'=>Yii::t('app','Delete'), 
    //                       'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
    //                       'data-request-method'=>'post',
    //                       'data-toggle'=>'tooltip',
    //                       'data-confirm-title'=>Yii::t('app','Are you sure?'),
    //                       'data-confirm-message'=>Yii::t('app','Are you sure want to delete this item')], 
    // ],

];   