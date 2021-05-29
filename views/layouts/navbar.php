<?php
use yii\helpers\Url;
use yii\helpers\Html;

$url = explode('/',Url::current());
array_shift($url);
array_shift($url);
$url = implode('/',$url);

$languages = [
    'ru' => 'Russian',
    'en' => 'English',
    'uz' => 'Uzbek',
];
$current_language = $languages[Yii::$app->language];
unset($languages[Yii::$app->language]);
?>
?>
<div class="top_nav">

    <div class="nav_menu">
        <nav class="" role="navigation">
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        
                        <?php //Html::img($user->getImage(),['alt' => Yii::t('app','User Avatar'), 'class' => 'img-circle'])?>
                        <?php // $user->fio ?>
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="<?=Url::toRoute(['/users/profile'])?>">  <?=Yii::t('app','Profile')?></a>
                        </li>
                        <!-- <li>
                            <a href="javascript:;">
                                <span class="badge bg-red pull-right">50%</span>
                                <span>Settings</span>
                            </a>
                        </li> -->
                        <!-- <li>
                            <a href="javascript:;">Help</a>
                        </li> -->
                        <li>
                            <?= Html::a('<i class="fa fa-sign-out pull-right"></i> ' . Yii::t('app','Logout'), '/site/logout', $options = ['data-method' => 'post'])?>
                        </li>
                    </ul>
                </li>
                <li class="" style="padding-left: 15px;">
                    <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                        <?=$current_language?>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                    <?php foreach($languages as $key=>$language):?>
                        <li><?= Html::a($language, [$url, 'language' => $key], ['class' => 'dropdown-item']) ?></li>
                    <?php endforeach ?>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>

</div>