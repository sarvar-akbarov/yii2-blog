<?php

const STATUS_ACTIVE = 1;
const STATUS_INACTIVE = 2;

function getStatus()
{
    return [
        STATUS_ACTIVE => \Yii::t('app','Active'),
        STATUS_INACTIVE => \Yii::t('app','Inactive'),
    ];
}


function dd($data){
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    die();
}