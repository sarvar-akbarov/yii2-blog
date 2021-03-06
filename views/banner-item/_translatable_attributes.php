<?php

?>
<input type="hidden" name="BannerItem[tab]" value="<?=$model->tab?>" id="tab">
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
                <div class="row" style="">
                    <div class="col-md-12">
                        <?php foreach($model->translatableAttributes() as $name=>$type):?>
                                <?php if($type == 'string'):?>
                                    <?= $form->field($model, "translatableAttr[$name][$key]")->textInput(['maxlength' => true,'id' => 'attr-'.$name.'-'.$i])->label($model->getAttributeLabel($name)) ?>
                                <?php elseif($type == 'text'): ?>
                                    <?= $form->field($model, "translatableAttr[$name][$key]")->textarea(['rows' => 6,'id' => 'attr-'.$name.'-'.$i])->label($model->getAttributeLabel($name)) ?>
                                <?php endif; ?>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        <?php $i++; endforeach ?>
    </div>
</div>
<hr>

<?php
$required_fields = isset($model->errors['attrs']) ? $model->errors['attrs'][0] : '';
$this->registerJs(<<<JS

    $('#myTabContent .form-group').removeClass('required has-error');
    $('#myTabContent .form-group .help-block').html('');

    var arr = '$required_fields'.split(',');
    var error_message = '???????????????????? ?????????????????? ?????? ????????';                                
    for (i =0; i < arr.length;  i++){
        let id = 'attr-' + arr[i] +'-1';
        div = $('#'+id).parent();
        div.addClass('required has-error');
        error_div = $('#'+id).next('div')
        error_div.html(error_message);
    }
JS
)
?>