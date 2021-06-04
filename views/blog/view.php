<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Blog */
?>
<div class="blog-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'category_id',
            'user_id',
            'date_cr',
            'slug',
            'image',
            'status',
            'view_count',
        ],
    ]) ?>

</div>
