<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Url;
use yii\helpers\Html;
use app\widgets\Alert;
use yii\widgets\Breadcrumbs;
$bundle = yiister\gentelella\assets\Asset::register($this);
$user = Yii::$app->user->identity;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.ico" type="image/ico" />
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="nav-<?= !empty($_COOKIE['menuIsCollapsed']) && $_COOKIE['menuIsCollapsed'] == 'true' ? 'sm' : 'md' ?>">

<body class="nav-md">
<?php $this->beginBody() ?>
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <?=$this->render('left')?>
        </div>
        <!-- top navigation -->
        <?=$this->render('header')?>
        <!-- /top navigation -->
        <!-- page content -->
        <div class="right_col" role="main">
          <?= Breadcrumbs::widget([
              // 'itemTemplate' => "<li><i>{link}</i></li>\n",
              'itemTemplate' => "<li><span>{link}<span></li>\n",
              'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
              'options' => ['class' => 'breadcrumb', 'style' => ''],
              'activeItemTemplate' => "<li class=\"active\">{link}</li>\n",

          ]) ?>
          <?= Alert::widget() ?>
          <?=$content?>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <?=$this->render('footer')?>
        </footer>
        <!-- /footer content -->
      </div>
    </div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
