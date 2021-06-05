<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Contact */
?>
<div class="contact-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'type',
            'user_id',
            'user_ip',
            'name',
            'email:email',
            'phone',
            'message:ntext',
            'user_agent:ntext',
            'date_cr',
            'viewed',
        ],
    ]) ?>

</div>
