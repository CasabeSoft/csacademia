<div class="row-fluid">
    <legend><?php echo lang('subject_filter')?></legend>
    <div class="accordion" id="acFilter">
        <div class="accordion-group">
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#acFilter" href="#collapseActive">
                    <?php echo lang('form_state')?>
                </a>
            </div>
            <div id="collapseActive" class="accordion-body collapse">
                <div class="accordion-inner">
                    <div class="btn-group" data-toggle="buttons-radio">
                        <button type="button" class="btn active" data-bind="click: filterByState.bind($data, true)"><?php echo lang('btn_active')?></button>
                        <button type="button" class="btn" data-bind="click: filterByState.bind($data, false)" ><?php echo lang('btn_inactive')?></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-group">
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#acFilter" href="#collapseGroup">
                    <?php echo lang('form_group')?>
                </a>
            </div>
            <div id="collapseGroup" class="accordion-body collapse">
                <div class="accordion-inner">
                    <select class="input-block-level" data-bind="value: filterByGroup">
                        <option value=""><?php echo lang('filter_all')?></option>
                        <?php foreach ($groups as $group) { ?>
                            <option value="<?php echo $group["id"] ?>"><?php echo $group["name"] ?></option>
                        <?php } ?>
                    </select>  
                </div>
            </div>
        </div>
    </div>
</div>