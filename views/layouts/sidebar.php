<?php
use yii\helpers\Html;
?>
<div class="col-md-3 left_col">

    <div class="left_col scroll-view">

        <div class="navbar nav_title" style="border: 0;">
            <a href="/" class="site_title"><i class="fa fa-graduation-cap"></i> <span>Metodist</span></a>
        </div>
        <div class="clearfix"></div>

        <!-- menu prile quick info -->
        <div class="profile">
            <div class="profile_pic">
                <img src="/images/user.png" alt="..." class="img-circle profile_img">

                <?php // Html::img($user->getImage(),['alt' => Yii::t('app','User Avatar'), 'class' => 'img-circle profile_img'])?>
            </div>
            <div class="profile_info">
                <span><?=Yii::t('app','Xush kelibsiz')?>,</span>
                <h2><?php //$user->fio?></h2>
            </div>
        </div>
        <!-- /menu prile quick info -->

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3><?php //$user->role->name?></h3>
                <?=$this->render('right-menu')?>
            </div>
        </div>
        <!-- /sidebar menu -->
    </div>
</div>