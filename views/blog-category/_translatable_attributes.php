<div class="" role="tabpanel" data-example-id="togglable-tabs">
    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
        <?php foreach($languages as $key=>$language): ?>
            <li role="presentation" class="active">
                <a href="#tab_content<?=$key?>" id="tab-<?=$key?>" role="tab" data-toggle="tab" aria-expanded="true">
                    <?=$language?>
                </a>
            </li>
        <?php endforeach ?>
    </ul>
    <div id="myTabContent" class="tab-content">
        <?php foreach($languages as $key=>$language): ?>
            <div role="tabpanel" class="tab-pane fade" id="tab_content<?=$key?>" aria-labelledby="tab-<?=$key?>">
                <p>
                <?=$language?>
                </p>
            </div>
        <?php endforeach ?>
    </div>
</div>