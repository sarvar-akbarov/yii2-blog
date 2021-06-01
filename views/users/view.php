<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
?>
<div class="users-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'login',
            'phone',
            'password',
            'fio',
            'avatar',
            'status',
            'permission',
        ],
    ]) ?>

</div>
