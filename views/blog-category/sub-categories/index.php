<?php
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $this->title = Yii::t('app', 'Categories');
// $this->params['breadcrumbs'][] = $this->title;

?>
<div class="panel panel-inverse documentation-index">
    <div class="panel-heading" style="background: #618A6B; color: #FDFEFE">
        <h4 class="panel-title"> <?= Yii::t('app','Sub-Categories')?></h4>
    </div>
    <div class="panel-body">
        <div id="ajaxCrudDatatableSub">
            <?=GridView::widget([
                'id'=>'crud-datatable-sub-categories',
                'dataProvider' => $dataProvider,
                'pjax'=>true,
                'columns' => require(__DIR__.'/_columns.php'),
                'toolbar'=> [
                    ['content'=>''],
                ],
                'striped' => true,
                'condensed' => true,
                'responsive' => true,
                'panel' => [
                    'headingOptions' => ['style' => 'display: none;'],
                    'after'=>'',
                    'footer' => false,
                ]
            ])?>
        </div>
    </div>
</div>
