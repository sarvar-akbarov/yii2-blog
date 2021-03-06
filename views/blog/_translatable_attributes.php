<?php
use dosamigos\ckeditor\CKEditor;
?>
<!-- <div class="alert alert-danger alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
    </button>
    <strong>Holy guacamole!</strong> Best check yo self, you're not looking too good.
</div> -->
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
                <div class="row" style="">
                    <div class="col-md-12">
                        <?php foreach($model->translatableAttributes() as $name=>$type):?>
                                <?php if($name == 'text'): ?>
                                    
                                    <?= $form->field($model, "translatableAttr[$name][$key]")
                                        ->widget(CKEditor::className(), 
                                            [
                                            'options' => [], 
                                            'preset' => 'custom',
                                            'clientOptions' => [
                                                'extraPlugins' => '',
                                                'height' => 200,
                                                //Here you give the action who will handle the image upload 
                                                'filebrowserUploadUrl' => '/blog/image-upload',

                                                'toolbarGroups' => [
                                                    ['name' => 'undo'],
                                                    ['name' => 'basicstyles', 'groups' => ['basicstyles', 'cleanup']],
                                                    ['name' => 'paragraph', 'groups' => ['list', 'indent', 'blocks', 'align', 'bidi' ]],
                                                    ['name' => 'styles'],
                                                    ['name' => 'links', 'groups' => ['links', 'insert']]
                                                ]
                                            ]
                                        ])->label($model->getAttributeLabel($name)); ?> 
                                <?php elseif($type == 'string'):?>
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
    var error_message = 'Необходимо заполнить эту поля';                                
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