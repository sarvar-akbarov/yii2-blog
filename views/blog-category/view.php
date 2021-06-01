<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BlogCategory */
?>
<div class="blog-category-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'numlevel',
            'icon_b',
            'icon_s',
            'keyword:ntext',
            'status',
            'parent_id',
        ],
    ]) ?>

</div>
