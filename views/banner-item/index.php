<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BannerItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
CrudAsset::register($this);
?>
<div class="banner-item-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a(Yii::t('app','Create'), ['/banner-item/create', 'banner_id' => $banner_id],
                    ['data-pjax' => 0,'title'=> 'Create new '.Yii::t('app','Banner Items'),'class'=>'btn btn-success'])
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'success', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> ' . Yii::t('app', 'Banner Items'),
                'after'=>BulkButtonWidget::widget([
                            'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp;' . Yii::t('app','Delete All'),
                                ["bulk-delete"] ,
                                [
                                    "class"=>"btn btn-danger btn-xs",
                                    'role'=>'modal-remote-bulk',
                                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                    'data-request-method'=>'post',
                                    'data-confirm-title'=>Yii::t('app','Are you sure?'),
                                    'data-confirm-message'=>Yii::t('app','Are you sure want to delete this item')
                                ]),
                        ]).                        
                        '<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>