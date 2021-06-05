
<?php

?>
<div class="" role="tabpanel" data-example-id="togglable-tabs">
    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="false"><?=Yii::t('app','Banners')?></a>
        </li>
        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="true"><?=Yii::t('app','Statistics')?></a>
        </li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
            <?= $this->render('tabs/tab1', [
                'model' => $model,
                'searchModel' => $searchModelBannerItem,
                'dataProvider' => $dataProviderBannerItem
            ])?>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
        <?= $this->render('tabs/tab2', [
                'model' => $model,
                'searchModel' => $searchModelBannerStatistic,
                'dataProvider' => $dataProviderBannerStatistic
            ])?>
        </div>
    </div>
</div>