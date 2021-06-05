<?php
use app\models\Blog;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\select2\Select2;

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
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'category_id',
        'value' => function($model){
            return array_values($model->category->translatableAttr['title'])[0];
        },
        'width' => '220px',
        'filter' => Blog::getCategoryList(),
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            // 'size' => Select2::SMALL,
            'options' => ['prompt' => Yii::t('app','Select'),],
            'pluginOptions' => ['allowClear' => true,'multiple' => true],
        ],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'title',
        'value' => function($model){
            return array_values($model->translatableAttr['title'])[0];
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'user_id',
        'value' => 'user.fio',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'date_cr',
        'format' => 'date',
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
        // 'attribute'=>'view_count',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['data-pjax' => 0,'title'=>Yii::t('app','View'),'data-toggle'=>'tooltip'],
        'updateOptions'=>['data-pjax' => 0,'title'=>Yii::t('app','Update'), 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>Yii::t('app','Delete'), 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>Yii::t('app','Are you sure?'),
                          'data-confirm-message'=>Yii::t('app','Are you sure want to delete this item')], 
    ],

];   