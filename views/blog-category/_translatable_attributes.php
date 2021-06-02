<?php

?>
<input type="hidden" name="BlogCategory[tab]" value="<?=$model->tab?>" id="tab">
<div class="" role="tabpanel" data-example-id="togglable-tabs">
    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
        <?php $i = 1; foreach($languages as $key=>$language): ?>
            <li role="presentation" class="<?=($i==$model->tab) ? 'active' : '' ?>">
                <a href="#tab_content-<?=$key?>" id="tab-<?=$key?>" role="tab" data-toggle="tab" aria-expanded="true">
                    <?=$language?>
                </a>
            </li>
        <?php $i++; endforeach ?>
    </ul>
    <div id="myTabContent" class="tab-content">
        <?php $i = 1; foreach($languages as $key=>$language): ?>
            <div role="tabpanel" class="tab-pane fade <?=($i==$model->tab) ? 'active in' : '' ?>" id="tab_content-<?=$key?>" aria-labelledby="tab-<?=$key?>">
                <p>
                <?php foreach($model->translatableAttributes() as $name=>$type):?>
                    <?php if($type == 'string'):?>
                        <?= $form->field($model, "translatableAttr[$name][$key]")->textInput(['maxlength' => true]) ?>
                    <?php elseif($type == 'text'): ?>
                        <?= $form->field($model, "translatableAttr[$name][$key]")->textarea(['rows' => 6]) ?>
                    <?php endif; ?>
                <?php endforeach ?>
                <?=$language?>
                </p>
            </div>
        <?php $i++; endforeach ?>
    </div>
</div>