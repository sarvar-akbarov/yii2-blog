<?php
use yii\helpers\Url;

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
        'class' => 'kartik\grid\ExpandRowColumn',
        'width' => '50px',
        'value' => function ($model, $key, $index, $column) {
            return \kartik\grid\GridView::ROW_COLLAPSED;
        },
        // uncomment below and comment detail if you need to render via ajax
        // 'detailUrl' => Url::to(['/site/book-details']),
        'detail' => function ($model, $key, $index, $column) {
            return Yii::$app->controller->renderPartial('sub-categories/index', ['dataProvider' => $model->getSubCategoryDataProvider()]);
        },
        'headerOptions' => ['class' => 'kartik-sheet-style'],
        'expandOneOnly' => true
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'icon_s',
        'format' => 'html',
        'content' => function($model){
            return $model->getLogo();
        }
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
        'attribute'=>'keyword',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'status',
        'value' => function($model){
            return getStatus()[$model->status];
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'sub_category',
        'header' => Yii::t('app','Sections'),
        'contentOptions'=>['class'=>'text-center'],
        'headerOptions'=>['class'=>'text-center'],
        'width' => '100px',
        'content' => function($data){
            return '<center>' . \yii\helpers\Html::a(Yii::t('app','Add'),
                    ['create', 'parent_id' => $data->id],
                    ['data-pjax' => 0,'title'=> Yii::t('app','Add'), 'class'=>'btn btn-warning']) . '</center>';
        }
    ],
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