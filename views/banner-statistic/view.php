<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BannerStatistic */
?>
<div class="banner-statistic-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'banner_id',
            'date',
            'clicks',
            'shows',
        ],
    ]) ?>

</div>
