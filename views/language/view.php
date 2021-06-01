<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Language */
?>
<div class="language-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'code',
            'local',
            'name',
            'image',
            'default',
            'status',
        ],
    ]) ?>

</div>
