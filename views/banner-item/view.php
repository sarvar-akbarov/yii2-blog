<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BannerItem */
?>
<div class="banner-item-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'banner_id',
            'type',
            'code:ntext',
            'img',
            'url:url',
            'show_start',
            'show_finish',
            'show_limit',
            'status',
            'target_blank',
            'sorting_number',
            'time:datetime',
        ],
    ]) ?>

</div>
